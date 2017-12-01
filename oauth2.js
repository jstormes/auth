/*
usage  <script src="oauth2.js" data-server="https://oauth.loopback.world" data-client_id="angularclient" data-client_password="testpass" data-scopes=""></script>

usage   <script src="oauth2.js"></script>
        <script>
            var config = [
                server:"https://oauth.loopback.world",
                client_id:"angularclient",
                client_password:"testpass",
                scopes:""
            ]
            oauth2.Authorize(config).then(app);
        </script>

        <script>
            var bearerToken = oauth2.token;
            var hasAccess = oauth2.isMemberOf("admin user superuser");
        </script>

 */

var oauth2 = (function() {
    "use strict";

    var storage = localStorage;

    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

    var refreshFactor = 0.5;

    var config;
    var defaults = {
        refreshFactor: 0.5,
        inactivityTimeoutInMinutes: 1,
        AuthorizationPath: "/oauth/authorize",
        // TODO: Change to apiPath
        RefreshPath: "/oauth",
        scopes: "",
        OAuthRedirectURL: baseUrl
    };

    var errorMsg="";

    function Authorize(cfg) {

        return new Promise( resolve => {

                config = mergeDefaultsWithConfig(cfg);

                //getValidToken(config).then(console.log("done1"));
                var g = getValidToken(config);
                g.then(function (data) {
                    console.log("getValidToken received");
                    resolve(data);
                });
            }
        );


        //config =  mergeDefaultsWithConfig(cfg);

        //return getValidToken(config);


    }

    function getValidToken(config) {


        if (foundStoredAuthorizationCode()) {

            console.log("foundStoredAuthorizationCode");

            var authCode = getStoredAuthorizationCode();
            removeStoredAuthorizationCode();




            return new Promise( (resolve) => {


                    var g = getTokenFromAuthorizationCode(authCode, config);
                        g.then( storeToken );
                        g.then(function (data){console.log("2");resolve(data);});

                        //resolve("cow");
                }

            );
            //return getTokenFromAuthorizationCode(authCode, config).then( storeToken );
            //return(getTokenFromAuthorizationCode(authCode, config).then( storeToken ));

            // return new Promise( (resolve, reject) => {
            //
            //         resolve()
            //
            //     }
            //
            // )

            // var p = new Promise( (resolve, reject) => {
            //
            //
            //
            //     var authCode = getStoredAuthorizationCode();
            //     removeStoredAuthorizationCode();
            //     resolve(getTokenFromAuthorizationCode(authCode, config).then( storeToken ));
            //     //     .then( storeToken )
            //     //     .then((data)=> {
            //     //         console.log("then after store");
            //     //         resolve(data);
            //     // });
            // });
            // return p;

        }


        // TODO: RequestToken before redirect.
        if (receivedAuthorizationCode()) {
            if (stateIsValid(getUrlParameter('state'))) {
                removeStoredState();

                if (referrerIsValid(document.referrer, config)) {
                    var authorizationCode = getUrlParameter('code');
                    // TODO:
                    // Blank screen
                    // TODO: Will clear body
                    //window.onload=function(){
                    //    document.body.innerHTML = "Loading";
                    //};
                    // getTokenFromAuthorizationCode(authCode, config);
                    // .then( storeToken )
                    // .then( redirectToOriginalURL );
                    storeAuthorizationCode(authorizationCode);
                    redirectToOriginalURL();
                    // dead code:
                    return;
                }
                else {
                    errorMsg += "Referrer is invalid ";
                }

            }
            else {
                errorMsg += "State is invalid ";
            }

            // TODO:
            // redirectToOauthServer(config, errorMsg);
        }

        if (tokenIsInvalid())
        {
            saveOriginalURL();
            redirectToOauthServer(config, errorMsg);
        }

        return new Promise( (resolve, reject) => {
            console.log("resolving to 1");
            resolve(1);
        });


    }

    function referrerIsValid(referrer, config) {
        if (referrer.indexOf(config.Server)!==-1) {
            return true;
        }
        return false;
    }

    function foundStoredAuthorizationCode() {
        return storage.getItem("authCode");
    }

    function storeAuthorizationCode(code) {
        storage.setItem("authCode",code);
    }

    function getStoredAuthorizationCode() {
        return storage.getItem("authCode");
    }

    function removeStoredAuthorizationCode() {
        storage.removeItem("authCode");
    }

    function mergeDefaultsWithConfig(config) {
        return Object.assign(config, defaults);
    }

    function receivedAuthorizationCode()
    {
        return isRequestVarSet('code');
    }

    function isRequestVarSet(name)
    {
        return getUrlParameter(name);
    }

    function getUrlParameter(name){

        name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search);
        if(name) {
            return decodeURIComponent(name[1]);
        }
        return false;
    }

    function removeStoredState() {
        storage.removeItem('OAUTH2_STATE');
    }

    function getTokenFromAuthorizationCode(code, config)
    {
        //if (!isAuthorizationInProcess) {

//            isAuthorizationInProcess=true;

        return new Promise( (resolve, reject) =>  {

            // Todo: rename this
            var oauth2ApiUrl = buildOAuthApiURL(config);

            var oauth2ApiRequest = {};
            oauth2ApiRequest.grant_type = 'authorization_code';
            oauth2ApiRequest.client_id = config.ClientId;
            // TODO: Make this constant
            oauth2ApiRequest.client_secret = config.ClientPassword;
            oauth2ApiRequest.code = code;
            oauth2ApiRequest.redirect_uri = config.OAuthRedirectURL;

            console.log("end  getTokenFromAuthorizationCode()")
            // Return apiRequest
            apiRequest(oauth2ApiUrl, oauth2ApiRequest).then(
                function(data) {
                    console.log("apiReqest resolved");
                    resolve(data);
                }
            );

        });


  //      }

    }

    function buildOAuthApiURL(config)
    {
        return config.Server + config.RefreshPath;
    }

    function stateIsValid(state)
    {
        if (storage.getItem('OAUTH2_STATE') !== state) {
            return false;
        }
        return true;
    }

    function redirectToOriginalURL()
    {
        // if (storage.getItem('OAUTH2_STATE') !== getUrlParameter('state'))
        // {
        //     throw 'State test failed!';
        // }
        // storage.removeItem('OAUTH2_STATE');
        //storeToken(data);
        var url = storage.getItem('SAVED_URL') + "";

        storage.removeItem('SAVED_URL');
        //isAuthorizationInProcess=false;
        window.location.replace (url);
    }

    function storeToken(token)
    {

        return new Promise ( (resolve, reject) => {
            // TODO: Rename tokens to oauth2_(something), fix case.
            storage.setItem('token',JSON.stringify(token));
            storage.setItem('EXPIRES_AT', getCurrentTime() + token.expires_in);
            storage.setItem('REFRESH_AT', Math.abs(getCurrentTime() + (token.expires_in * refreshFactor)));

            console.log("End storeToken()");
            resolve( token );
        });

    }

    //buildRequestAuthCodeURL()
    function buildCodeRequestURL(config,msg)
    {
        // TODO: pass the state in as a parameter.
        var state = generateRandomString();
        storage.setItem('OAUTH2_STATE',state);

        var url =  config.Server;
        url += config.AuthorizationPath;
        url += "?response_type=code";
        url += "&client_id=" + config.ClientId;
        url += "&state=" + state;
        url += "&scope=" + config.Scopes;
        url += "&redirect_uri=" + config.OAuthRedirectURL;
        url += "&msg=" + encodeURIComponent(msg);

        return url;
    }

    function tokenIsInvalid() {
        var isInvalid = ( getCurrentTime() > (storage.getItem('EXPIRES_AT')));
        return ( isInvalid );
    }

    function saveOriginalURL() {
        storage.setItem('SAVED_URL', window.location.href);
    }

    function redirectToOauthServer(config, msg) {
        var url = buildCodeRequestURL(config, msg);
        window.location.replace (url);
    }

    function generateRandomString()
    {
        var randomString;

        randomString =  Math.random().toString(36).substr(2);
        randomString += Math.random().toString(36).substr(2);

        return randomString;
    }

    function getCurrentTime() {
        var date = new Date();
        return  (date.getTime()/1000|0);
    }

    function apiRequest(url, data)
    {
        // Return a new promise.
        var postJSON = JSON.stringify(data);

        // TODO: investigate "then" proper way.  check the use of Promise.
        //


        return new Promise(function(resolve, reject) {
            // Do the usual XHR stuff
            var req = new XMLHttpRequest();

            req.open('POST', url, true);
            req.setRequestHeader("Content-type", "application/json");

            req.onload = function() {
                // This is called even on 404 etc
                // so check the status
                if (req.status === 200) {
                    // Resolve the promise with the response text
                    console.log("req returned");
                    resolve(JSON.parse(req.response));
                }
                else {
                    // Otherwise reject with the status text
                    // which will hopefully be a meaningful error
                    reject(Error(req.statusText));
                }
            };

            // TODO: thow error?
            // Handle network errors
            req.onerror = function() {
                reject(Error("Network Error"));
            };

            // Make the request
            req.send(postJSON);
        });
    }


    function getConfigScriptParams() {
        var scripts = document.getElementsByTagName('script');
        var lastScript = scripts[scripts.length-1];
        var scriptName = lastScript;
        return {
            Server : scriptName.getAttribute('data-server').toString(),
            ClientId : scriptName.getAttribute('data-client_id').toString(),
            ClientPassword : scriptName.getAttribute('data-client_password').toString(),
            Scopes : scriptName.getAttribute('data-scopes').toString()
        };
    }



    Authorize(getConfigScriptParams()).then((data)=> {console.log("done")});


    return {
      "Authorize" : Authorize
    };


})();