(function(d,t) {
    var BASE_URL= chatwoot_url;
    var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=BASE_URL+"/packs/js/sdk.js";
    s.parentNode.insertBefore(g,s);
    g.onload=function(){
      window.chatwootSDK.run({
        websiteToken: chatwoot_token,
        baseUrl: BASE_URL
      })
    }
  })(document,"script");
