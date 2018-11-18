<?php

namespace Drupal\ajax_sample\Controller;

class AjaxSampleController {

  /**
   * {@inheritdoc}
   */
  public function content() {
    $config = \Drupal::config('ajax_sample.settings');
    return [
      '#type' => 'markup',
      '#markup' => t('
      
<style>

.ajaxBtn{
  border: 2px solid #E91E63;
  padding: 6px 16px;
  color: #3F51B5;
  border-radius: 5px;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  font-family: monospace;
  font-size: 16px;
  cursor: pointer;
  outline: none;
  background: #fff;
  font-weight: bold;
  transition: all 0.3s;
  display: block;
  margin: auto;
}

.ajaxBtn:hover{
  background: linear-gradient(to top right, #E91E63, #3F51B5);
  box-shadow: 2px 2px 5px #333;
  color: #fff;
  padding: 10px 25px;
  letter-spacing: 2px;
  border: none;
}

#myAlert{
  display: none;
  position: fixed;
  background: rgba(0, 0, 0, 0.8);
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  animation: fadein 0.3s;
  font-family: monospace;
  z-index: 999;
}
@keyframes fadein{
  0% {opacity: 0;}
  100% {opacity: 1;}
}
#myAlert > div{
  box-shadow: 2px 2px 5px #333;
  border-radius: 10px;
  background: #fff;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
  width: 450px;
  max-width: calc(90% - 50px);
  max-height: calc(80% - 50px);
  padding: 25px;
  animation: rollin 0.5s;
}
@keyframes rollin{
  0% {top: -100px; opacity: 0;}
  100% {top: 0; opacity: 1;}
}
#myAlert_link{
  text-decoration: none;
  color: green;
}
#myAlert_resp{
  background-color: #ddd;
  overflow: auto;
  height: calc(100% - 25px);
  word-wrap: break-word;
}
#myAlert_close{
  color: #fff;
  background: transparent;
  border: 0;
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 20px;
  cursor: pointer;
  outline: none;
}

</style>
<p>Click the button below to make the AJAX call.</p>
<button onclick="ajaxSample()" class="ajaxBtn">
  Make AJAX Call
</button>
<div id="myAlert">
    &times;
  </button>
  <div>
    <a id="myAlert_link" href=""></a>
    <pre id="myAlert_resp"></pre>
  </div>
</div>
<script>

function ajaxSample(){
  url = "' . $config->get('ajax_sample.url') . '";
  jQuery("#myAlert_resp").load(url);
  jQuery("#myAlert").show();
  jQuery("#myAlert_link").attr("href", url);
  jQuery("#myAlert_link").html(url);
}

</script>

      '),
    ];
  }

}
