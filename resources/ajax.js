/**
 * @fileoverview A simple ajax library
 * @author Ryan Leonard
 */

/*
 * Params object documentation
 * boolean ajax({string url [, object data] [, function onSuccess(response)] [, function onFailure]})
 * url [A string containing the location to connect to, along with any get variables]
 * data [An object containing key value pairs to pass as POST data to the server]
 * onSuccess(response) [A function to run after the server get a response, which is passed]
 * onFailure [A function to run if the server doesn't get a 200 status response]
 */

/*
 * Sample Usage:
ajax({
    url: "/echo/json/",
    data: {
        json: JSON.stringify({
            echo: "Hello World from Simulated Ajax call"
        })
    },
    onSuccess: function(response) {
        console.log(response);
        document.body.innerHTML = JSON.parse(response.responseText).echo;
    }
});
 */

/**
 * Runs a basic ajax connection
 * @param {Object} params
 * @returns {Boolean} Returns false if the connection object was unable to be created
 */

function ajax(params) {
    var httpRequest;
    if (window.XMLHttpRequest) {
        httpRequest = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        try {
            httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e) {
            try {
                httpRequest = newActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e) {}
        }
    }
    if (!httpRequest) {
        return false;
    }
    httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState === 4) {
            if (httpRequest.status === 200 && params["onSuccess"]) {
                params["onSuccess"](this);
            }
            else if (httpRequest.status !== 200 && params["onFailure"]) {
                params["onFailure"]();
            }
        }
    };
    if (params.data) {
        httpRequest.open("POST", params.url);
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        var data = "";
        for(key in params.data) {
            if(data != "") { data += "&"; }
            data += encodeURIComponent(key) + "=" + encodeURIComponent(params.data[key]);
        }
        httpRequest.send(data);
        return true;
    }
    else {
    	httpRequest.open("GET", params.url);
    	httpRequest.send();
    	return true;
    }
}