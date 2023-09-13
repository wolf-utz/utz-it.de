const registerServiceWorker = async () : Promise<void> => {
    if (!("serviceWorker" in window.navigator)) {
        return
    }
    try {
        await navigator.serviceWorker.register("/sw.js", { scope: "/" });
    } catch (error) {
        console.error(`Registration failed with ${error}`);
    }
};
registerServiceWorker();