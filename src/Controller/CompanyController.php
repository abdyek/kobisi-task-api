<?php

namespace Kobisi\CompanyService\Controller;

use Kobisi\CompanyService\Core\Endpoint;
use Kobisi\CompanyService\Core\DefaultController;
use Kobisi\CompanyService\Model\CompanyModel;

class CompanyController extends DefaultController
{
    private CompanyModel $companyModel;

    public function __construct(Endpoint $endpoint, CompanyModel $companyModel)
    {
        parent::__construct(...func_get_args());
        $this->companyModel = $companyModel;
        $this->companyModel->setDatabase($this->endpoint->getDatabase());
    }

    public function register(): void
    {
        $content = $this->endpoint->getRequest()->getContent();
        $config = $this->endpoint->getConfig();
        $response = $this->endpoint->getResponse();

        $company = $this->companyModel->getByEmail($content['email']);
        if($company !== null) {
            $response->setStatus('fail');
            $response->setContent([
                'message' => 'this email already registered'
            ]);
            return;
        }

        $content['password'] = password_hash($content['password'], PASSWORD_DEFAULT);
        $this->companyModel->create($content);

        $companyId = (int) $this->companyModel->getByEmail($content['email'])['id'];

        $JWTObject = $this->endpoint->getAuthenticator()->getJWTObject();
        $JWTObject->setClaims([
            'exp' => time() + 3600,
            'who' => 'authenticated',
            'companyId' => $companyId
        ]);

        $response->setContent([
            'token' => $JWTObject->generateToken(),
            'company_id' => $companyId
        ]);
    }

    public function login(): void
    {
        $this->endpoint->getResponse()->setContent([
            'message' => 'here is going to be login'
        ]);
    }

    public function check(): void
    {
        $this->endpoint->getResponse()->setContent([
            'message' => 'here is going to be check'
        ]);
    }
}
