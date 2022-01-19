<?php

namespace Kobisi\CompanyService\Controller;

use Kobisi\CompanyService\Core\Endpoint;
use Kobisi\CompanyService\Core\DefaultController;
use Kobisi\CompanyService\Model\PackageModel;
use Kobisi\CompanyService\Model\CompanyPackageModel;

class PackageController extends DefaultController
{
    private PackageModel $packageModel;
    private CompanyPackageModel $companyPackageModel;

    public function __construct(Endpoint $endpoint, PackageModel $packageModel, CompanyPackageModel $companyPackageModel)
    {
        parent::__construct(...func_get_args());
        $this->packageModel = $packageModel;
        $this->companyPackageModel = $companyPackageModel;

        $this->packageModel->setDatabase($this->endpoint->getDatabase());
        $this->companyPackageModel->setDatabase($this->endpoint->getDatabase());
    }

    public function showPackages(): void
    {
        $response = $this->endpoint->getResponse();
        $packages = $this->packageModel->getAll();
        $response->setContent([
            'packages' => $packages
        ]);
    }

    public function set(): void
    {
        $content = $this->endpoint->getRequest()->getContent();
        $response = $this->endpoint->getResponse();
        $authenticator = $this->endpoint->getAuthenticator();

        $available = $this->companyPackageModel->getByCompanyId($authenticator->getCompanyId());
        if($available !== null) {
            $response->setStatus('fail');
            $response->setContent([
                'message' => 'Your company already has a package'
            ]);
            return;
        }

        if($authenticator->getCompanyId() !== $content['company_id']) {
            $response->forbidden();
        }

        $package = $this->packageModel->getById($content['package_id']);
        if(!$package) {
            $response->notFound();
            return;
        }

        $duration = ($package['payment_type'] === 'yearly' ? 31557600 : 2592000);

        $dateTime = new \DateTime();
        $start = $dateTime->format('Y-m-d H:i:s');

        $dateTime->setTimestamp($dateTime->getTimestamp() + $duration);
        $end = $dateTime->format('Y-m-d H:i:s');

        $content['start_datetime'] = $start;
        $content['end_datetime'] = $end;

        unset($content['token']);
        $this->companyPackageModel->attachCompanyWithPackage($content);
    }
}
