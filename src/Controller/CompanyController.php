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
        // TODO: prevent data duplication

        $responseContent = $this->endpoint->getRequest()->getContent();
        $config = $this->endpoint->getConfig();
        $this->companyModel->create($responseContent);

        $companyId = (int) $this->companyModel->getByEmail($responseContent['email'])['id'];

        $JWTObject = $this->endpoint->getAuthenticator()->getJWTObject();
        $JWTObject->setClaims([
            'exp' => time() + 3600,
            'who' => 'authenticated',
            'companyId' => $companyId
        ]);

        $this->endpoint->getResponse()->setContent([
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
