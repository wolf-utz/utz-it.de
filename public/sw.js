importScripts('/workbox/workbox-v7.0.0/workbox-sw.js');

workbox.setConfig({
    modulePathPrefix: '/workbox/workbox-v7.0.0/',
    debug: false
});

const navigationRoute = new workbox.routing.NavigationRoute(new workbox.strategies.NetworkFirst({
    cacheName: 'navigations'
}));

const staticAssetRoute = new workbox.routing.Route(({request}) => {
    return ['image', 'script', 'font', 'manifest'].includes(request.destination)
}, new workbox.strategies.NetworkFirst({
    cacheName: 'app-assets'
}));

workbox.routing.registerRoute(navigationRoute);
workbox.routing.registerRoute(staticAssetRoute);
