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
        $content = $this->endpoint->getRequest()->getContent();
        $response = $this->endpoint->getResponse();

        $company = $this->companyModel->getByEmail($content['email']);
        if(!$company or !password_verify($content['password'], $company['password'])) {
            $response->unauthorized();
        }

        $JWTObject = $this->endpoint->getAuthenticator()->getJWTObject();
        $JWTObject->setClaims([
            'exp' => time() + 3600,
            'who' => 'authenticated',
            'companyId' => $company['id']
        ]);

        $response->setContent([
            'token' => $JWTObject->generateToken(),
            'company_id' => $company['id']
        ]);
    }

    public function check(): void
    {
        $this->endpoint->getResponse()->setContent([
            'message' => 'here is going to be check'
        ]);
    }
}
