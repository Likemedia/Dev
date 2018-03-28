<?php

//
// if(!is_null(Request::segment(7))){
//     Breadcrumbs::register(Request::segment(7), function($breadcrumbs, $segment1, $segment2, $segment3, $segment4, $lang)
//     {
//         $breadcrumbs->parent(Request::segment(5), $segment1, $segment2, $segment3, $lang);
//         $breadcrumbs->push(ucfirst($segment4),  urlForLanguageBreadcrumbs($lang, 'memberslist'));
//     });
// }
//
// if(!is_null(Request::segment(6))){
//     Breadcrumbs::register(Request::segment(6), function($breadcrumbs, $segment1, $segment2, $segment3, $segment4, $lang)
//     {
//         $breadcrumbs->parent(Request::segment(5), $segment1, $segment2, $segment3, $lang);
//         $breadcrumbs->push(ucfirst($segment4),  urlForLanguageBreadcrumbs($lang, 'memberslist'));
//     });
// }
//
// if(!is_null(Request::segment(5))){
//     Breadcrumbs::register(Request::segment(5), function($breadcrumbs, $segment1, $segment2, $segment3, $lang)
//     {
//         $breadcrumbs->parent(Request::segment(3), $segment1, $segment2);
//         $breadcrumbs->push(ucfirst($segment3),  urlForLanguageBreadcrumbs($lang, 'memberslist'));
//     });
// }
//
// if(!is_null(Request::segment(4))){
//     Breadcrumbs::register(Request::segment(4), function($breadcrumbs, $segment1, $segment2, $segment3, $lang)
//     {
//         $breadcrumbs->parent(Request::segment(3), $segment1, $segment2);
//         $breadcrumbs->push(ucfirst($segment3),  urlForLanguageBreadcrumbsAction($lang, 'memberslist'));
//     });
// }
// if(!is_null(Request::segment(3))){
//     Breadcrumbs::register(Request::segment(3), function($breadcrumbs, $segment1, $segment2)
//     {
//         $breadcrumbs->parent(Request::segment(2), $segment1);
//         $breadcrumbs->push(ucfirst($segment2), url(Request::segment(1), [Request::segment(2), Request::segment(3)]));
//     });
// }
//
// if(!is_null(Request::segment(2))){
//     Breadcrumbs::register(Request::segment(2), function($breadcrumbs, $segment1)
//     {
//         $breadcrumbs->push(ucfirst($segment1), url(Request::segment(1), Request::segment(2)));
//     });
// }
