window.chatwootSettings = {
  locale: chatwoot_widget_locale,
  type: chatwoot_widget_type,
  position: chatwoot_widget_position,
  launcherTitle: chatwoot_launcher_text,
};

(function(d,t) {
  var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
  g.async=!0;
  g.defer=!0;
  g.src=chatwoot_url+"/packs/js/sdk.js";
  s.parentNode.insertBefore(g,s);
  g.onload=function(){
    window.chatwootSDK.run({ websiteToken: chatwoot_token, baseUrl: chatwoot_url })
  }
})(document,"script");
