<!-- BEGIN: Two Click plugin for Facebook, G+ and Twitter - - - - - - - - - - - -->
<div id="fb-root"></div>
<script language="Javascript">
/**
 * Thanks to
 *  http://turkeyland.net/projects/two-click/ 
 * For the Facebook/Google two-click 
 **/
  
  function fb_init(d, s, id) {
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) return;
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/de_DE/sdk.js#xfbml=1&version=v2.0";
     fjs.parentNode.insertBefore(js, fjs);
  }
 
  function dg_fb_init() {


     // Init Facebook buttons
     var elem = document.getElementById("dg_fb_placeholder");
     elem.innerHTML = "<div class=\"fb-like\" data-href=\"https://developers.facebook.com/docs/plugins/\" data-width=\"32\" data-layout=\"standard\" data-action=\"like\" data-show-faces=\"false\" data-share=\"false\"></div>";

     //fb_init(document, 'script', 'facebook-jssdk');


     var e = document.createElement('script'); e.async = true;
     e.src = document.location.protocol +
                 '//connect.facebook.net/en_US/all.js#xfbml=1';
     document.getElementById('fb-root').appendChild(e);

}

function dg_gplus_init() {
   var url = document.location.href;
   var elem = document.getElementById("dg_gplus_placeholder");
   elem.innerHTML = "<div class=\"g-plusone\" data-size=\"small\" data-href=\""+url+"\"></div>\n";

   // This is the code provided by Google to asynchronously load their SDK
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
}

function dg_twitter_init() {
   var url = document.location.href;
   var elem = document.getElementById("dg_twitter_placeholder");
   elem.innerHTML = "<a href=\"https://twitter.com/share\" class=\"twitter-share-button\" data-lang=\"en\">Tweet</a>\n";

   !function(d,s,id) {
      var js,fjs=d.getElementsByTagName(s)[0];
      if(!d.getElementById(id)){
         js=d.createElement(s);
         js.id=id;js.src="https://platform.twitter.com/widgets.js";
         fjs.parentNode.insertBefore(js,fjs);
      }
   }(document,"script","twitter-wjs");
}
</script>


<div id="dg_fb_placeholder" style="margin: 2px;">
  <button onclick="dg_fb_init();" class="social_two_click" style="background-color: #3E578D;">Share on Facebook ...</button>
</div>

<div id="dg_gplus_placeholder" style="margin: 2px;">
  <button onclick="dg_gplus_init();" class="social_two_click" style="background-color: #CB4437;">Share on G+ ...</button>
</div>

<div id="dg_twitter_placeholder" style="margin: 2px;">
  <button onclick="dg_twitter_init();" class="social_two_click" style="background-color: #55ACEE;">Share on Twitter ...</button>
</div>
<div style="width: 300px; font-size: 7pt; color: #686868; text-align: justify; margin-left: 40px; margin-top: 10px;">
  Informational: this is a two-click social media plugin. It allows hidden web 
  surfing, as it blocks visitor tracking for external services such as
  Facebook, Google+ and Twitter.<br/>
  Only by clicking onto one of the buttons the remote service will notice
  you were here.
</div>
<!-- END: Two Click plugin for Facebook, G+ and Twitter - - - - - - - - - - - -->
