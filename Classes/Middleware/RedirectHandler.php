<?php

declare(strict_types=1);


namespace BDM\BdmMiddlewareRedirectWithTsfe\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Redirects\Service\RedirectService;


class RedirectHandler extends \TYPO3\CMS\Redirects\Http\Middleware\RedirectHandler{


    /**
     * @var RedirectService
     */
    protected $redirectService;
    public function __construct(RedirectService $redirectService)
    {
        $this->redirectService = $redirectService;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $tempMockTSFE = false;
        if(!isset($GLOBALS['TSFE']) || !is_object($GLOBALS['TSFE']) || !$GLOBALS['TSFE'] instanceof TypoScriptFrontendController) {
            $site = $request->getAttribute('site', null);
            /** @var ObjectManager $objectManager */
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            $lang = $site->getDefaultLanguage();
            $siteLanguage = $objectManager->get(SiteLanguage::class, $lang->getLanguageId(), $lang->getLocale(), $lang->getBase(), []);
            /** @var TypoScriptFrontendController $TSFE */
            $TSFE = $objectManager->get(
                TypoScriptFrontendController::class,
                GeneralUtility::makeInstance(Context::class),
                $site,
                $siteLanguage,
                GeneralUtility::_GP('no_cache'),
                GeneralUtility::_GP('cHash')
            );
            $backup = $GLOBALS['TSFE'];
            $tempMockTSFE = true;
            $GLOBALS['TSFE'] = $TSFE;
        }

        $result = parent::process($request, $handler);

        if($tempMockTSFE){
            $GLOBALS['TSFE'] = $backup;
        }
        return $result;
    }
}
