<?php
// typo3/cms-frontend/tsfe

/**
 * Definitions for middlewares provided by EXT:redirects
 */
$rearrangedMiddlewares = TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    TYPO3\CMS\Core\Configuration\Features::class
)->isFeatureEnabled('rearrangedRedirectMiddlewares');



return [
    'frontend' => [
//        'bdm/cms-frontend/base-redirect-resolver' => [
//            'target' => \BDM\BdmMiddlewareRedirectWithTsfe\Middleware\SiteBaseRedirectResolver::class,
//            'after' => [
//                'typo3/cms-frontend/site-resolver',
//                'typo3/cms-frontend/tsfe',
//            ],
//
//        ],
//        'typo3/cms-frontend/base-redirect-resolver' => [
//            'disabled' => true,
//        ],
        'bdm/cms-redirects/redirecthandler' => [
            'target' => \BDM\BdmMiddlewareRedirectWithTsfe\Middleware\RedirectHandler::class,
//            'after' => [
//                'typo3/cms-frontend/site-resolver',
////                'typo3/cms-frontend/tsfe',
//            ],
            'before' => [
                $rearrangedMiddlewares ? 'typo3/cms-frontend/base-redirect-resolver' : 'typo3/cms-frontend/page-resolver',
            ],
            'after' => [
                $rearrangedMiddlewares ? 'typo3/cms-frontend/authentication' : 'typo3/cms-frontend/static-route-resolver',
            ],

        ],
        'typo3/cms-redirects/redirecthandler' => [
            'disabled' => true,
        ],
    ]
];
