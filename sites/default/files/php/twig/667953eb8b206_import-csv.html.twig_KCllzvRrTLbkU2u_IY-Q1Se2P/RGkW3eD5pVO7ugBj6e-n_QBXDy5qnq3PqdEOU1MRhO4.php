<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* modules/custom/import_csv/templates/import-csv.html.twig */
class __TwigTemplate_97808f2bd7175dc5923cbca6044a1580 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<form  action=\"\"  id=\"UploadMediaForm\" name=\"UploadMediaForm\" method=\"POST\" enctype=\"multipart/form-data\"> 

\t<div >
\t  <a style=\"color: #000; padding: 10px; border: solid 1px #000; cursor: pointer;\" class=\"pure-material-button-contained\" onclick=\"\$('#SelectFile').click();\">
\t           Select File
\t  </a> </br></br>
\t <text style=\"color:#3bc8e7;\"> File Name:</text>  <text id=\"FileNameUpadteText\" style=\"color:#000\">...</text>
\t <input id=\"SelectFile\" name=\"SelectFile\" type=\"file\" accept=\".csv\" style=\"display:none;\" >
\t</div>

\t<br>

\t<text id=\"UploadProgressPercentMain\" style=\"color:#000;display:none;\">
\t    Working... <b><text id=\"UploadProgressPercent\"></text>%</b>
\t</text>

    <div id=\"loadingUploadFile\" style=\"border-radius:5px;overflow:hidden;height:80px;width:80px;margin:0 auto;display:none;\">
       Working...All done, saving to DB...
\t</div> 

    <div id=\"UploadFileResponseAlt\" style=\"padding:2px;background-color:#fff;border-radius:5px;color:#000;margin:0 auto;width:600px;text-align:center;display:none;\">
        ...
\t</div>

    <div id=\"UploadFileResponse\" style=\"padding:2px;background-color:#fff;border-radius:5px;color:#000;margin:0 auto;width:600px;text-align:center;display:none;\">
        ...
\t</div>


\t<a id=\"BtnUploadFile\" style=\"color: #fff; margin-top: 5px; background: #000; padding: 10px; cursor: pointer;display:none;margin-top:5px;\" class=\"pure-material-button-contained\" onclick=\"SubmitFormActionMain();\">
\t Generate Draft
\t</a> 

</form>

  <form  action=\"\"  id=\"UploadDraftForm\" name=\"UploadDraftForm\" method=\"POST\" enctype=\"multipart/form-data\"> 
    <input type=\"hidden\" id=\"UploadDraftContent\" name=\"UploadDraftContent\" value=\"0\" >
     <input type=\"hidden\" id=\"csvFilePath\" name=\"csvFilePath\" value=\"0\" >
  </form>

 <form  action=\"\"  id=\"DeleteDraftForm\" name=\"DeleteDraftForm\" method=\"POST\" enctype=\"multipart/form-data\"> 
     <input type=\"hidden\" id=\"DeleteDraftcsvFilePath\" name=\"DeleteDraftcsvFilePath\" value=\"0\" >
  </form>

<script type=\"text/javascript\" src=\"https://code.jquery.com/jquery-3.6.0.min.js\"></script>

<script>


\$(document).ready(function() {
    // jQuery document ready function
    document.getElementById('SelectFile').onchange = function () {
\t  \$('#FileNameUpadteText').html(document.getElementById('SelectFile').value);
      \$('#BtnUploadFile').show();
      \$(\"#UploadFileResponse\").hide();
\t}; 
});

\t\tfunction SubmitFormActionMain(){     
\t\t   \$(\"#UploadFileResponse\").show();
\t\t   \$(\"#UploadFileResponse\").html('Working...');    
\t\t   \$(\"#UploadProgressPercentMain\").show();
\t\t   \$(\"#BtnUploadFile\").hide();
\t\t   

\t\t  var UploadMediaURL = \"import-process\";

\t\t   var myform = document.getElementById(\"UploadMediaForm\");
\t\t    var fd = new FormData(myform );
\t\t    \$.ajax({
\t\t            xhr: function() {
\t\t                var xhr = new window.XMLHttpRequest();
\t\t        
\t\t                // Upload progress
\t\t                xhr.upload.addEventListener(\"progress\", function(evt){
\t\t                    if (evt.lengthComputable) {
\t\t                        var percentComplete = evt.loaded / evt.total;
\t\t                        //Do something with upload progress
\t\t                       percentComplete=percentComplete*100;
\t\t                       percentComplete =Math.round(percentComplete);                                    
\t\t                        \$('#UploadProgressPercent').html(percentComplete);


\t\t\t\t\t\t\t\tif(percentComplete=='100'){
\t\t\t\t\t\t\t\t\t\$('#UploadProgressPercent').html('Status: file send to server...');
\t\t\t\t\t\t\t\t}

\t\t                    }
\t\t               }, false);
\t\t               
\t\t               // Download progress
\t\t               xhr.addEventListener(\"progress\", function(evt){
\t\t                   if (evt.lengthComputable) {
\t\t                       var percentComplete = evt.loaded / evt.total;
\t\t                       // Do something with download progress
\t\t                       percentComplete=percentComplete*100;
\t\t                       percentComplete =Math.round(percentComplete);
\t\t                       \$('#UploadProgressPercent').html(percentComplete);
\t\t                   }
\t\t               }, false);
\t\t               
\t\t               return xhr;
\t\t            },                    
\t\t        url: UploadMediaURL,
\t\t        data: fd,
\t\t        cache: false,
\t\t        processData: false,
\t\t        contentType: false,
\t\t        type: 'POST',
\t\t        success: function (data) {
\t\t            // do something with the result
\t\t            
\t\t            \$(\"#UploadProgressPercentMain\").hide();
\t\t            
\t\t            \$(\"#UploadFileResponse\").html(data);

\t\t             var UploadDraftContentSub = \$(\"#UploadDraftContentSub\").val();
\t\t             \$(\"#UploadDraftContent\").val(UploadDraftContentSub);
                     
\t\t             var csvFilePathSub = \$(\"#csvFilePathSub\").val();
\t\t             \$(\"#csvFilePath\").val(csvFilePathSub);
\t\t             \$(\"#DeleteDraftcsvFilePath\").val(csvFilePathSub);

\t\t            //clear attached file
\t\t\t        \$(\"#SelectFile\").val(\"\");
\t\t\t        \$(\"#FileNameUpadteText\").html(\"\");
\t\t 
\t\t        }

\t\t    });    
\t\t}


\t\tfunction SaveProcess(){     

\t\t   \$(\"#UploadFileResponseAlt\").show();
\t\t   \$(\"#UploadFileResponseAlt\").html('Working...saving data...');    
\t\t   \$(\"#UploadProgressPercentMain\").show();
\t\t   \$(\"#BtnUploadFile\").hide();
\t\t   

\t\t  var UploadMediaURL = \"import-process-save\";

\t\t   var myform = document.getElementById(\"UploadDraftForm\");
\t\t    var fd = new FormData(myform );
\t\t    \$.ajax({
\t\t            xhr: function() {
\t\t                var xhr = new window.XMLHttpRequest();
\t\t        
\t\t                // Upload progress
\t\t                xhr.upload.addEventListener(\"progress\", function(evt){
\t\t                    if (evt.lengthComputable) {
\t\t                        var percentComplete = evt.loaded / evt.total;
\t\t                        //Do something with upload progress
\t\t                       percentComplete=percentComplete*100;
\t\t                       percentComplete =Math.round(percentComplete);                                    
\t\t                        \$('#UploadProgressPercent').html(percentComplete);


\t\t\t\t\t\t\t\tif(percentComplete=='100'){
\t\t\t\t\t\t\t\t\t\$('#UploadProgressPercent').html('Status: saving data...');
\t\t\t\t\t\t\t\t}

\t\t                    }
\t\t               }, false);
\t\t               
\t\t               // Download progress
\t\t               xhr.addEventListener(\"progress\", function(evt){
\t\t                   if (evt.lengthComputable) {
\t\t                       var percentComplete = evt.loaded / evt.total;
\t\t                       // Do something with download progress
\t\t                       percentComplete=percentComplete*100;
\t\t                       percentComplete =Math.round(percentComplete);
\t\t                       \$('#UploadProgressPercent').html(percentComplete);
\t\t                   }
\t\t               }, false);
\t\t               
\t\t               return xhr;
\t\t            },                    
\t\t        url: UploadMediaURL,
\t\t        data: fd,
\t\t        cache: false,
\t\t        processData: false,
\t\t        contentType: false,
\t\t        type: 'POST',
\t\t        success: function (data) {
\t\t            // do something with the result
\t\t            
\t\t            \$(\"#UploadProgressPercentMain\").hide();
\t\t            \$(\"#UploadFileResponseAlt\").hide();
\t\t            \$(\"#UploadFileResponse\").html(data);

\t\t            //clear attached file
\t\t\t        \$(\"#SelectFile\").val(\"\");
\t\t\t        \$(\"#FileNameUpadteText\").html(\"\");
\t\t 
\t\t        }

\t\t    });    
\t\t}

\t\tfunction DeleteDraft(){     

\t\t   \$(\"#UploadFileResponseAlt\").show();
\t\t   \$(\"#UploadFileResponseAlt\").html('Working...Deleting draft and csv file...');    
\t\t   \$(\"#UploadProgressPercentMain\").show();
\t\t   \$(\"#BtnUploadFile\").hide();
\t\t   

\t\t  var UploadMediaURL = \"import-process-delete\";

\t\t   var myform = document.getElementById(\"DeleteDraftForm\");
\t\t    var fd = new FormData(myform );
\t\t    \$.ajax({
\t\t            xhr: function() {
\t\t                var xhr = new window.XMLHttpRequest();
\t\t        
\t\t                // Upload progress
\t\t                xhr.upload.addEventListener(\"progress\", function(evt){
\t\t                    if (evt.lengthComputable) {
\t\t                        var percentComplete = evt.loaded / evt.total;
\t\t                        //Do something with upload progress
\t\t                       percentComplete=percentComplete*100;
\t\t                       percentComplete =Math.round(percentComplete);                                    
\t\t                        \$('#UploadProgressPercent').html(percentComplete);


\t\t\t\t\t\t\t\tif(percentComplete=='100'){
\t\t\t\t\t\t\t\t\t\$('#UploadProgressPercent').html('Status: saving data...');
\t\t\t\t\t\t\t\t}

\t\t                    }
\t\t               }, false);
\t\t               
\t\t               // Download progress
\t\t               xhr.addEventListener(\"progress\", function(evt){
\t\t                   if (evt.lengthComputable) {
\t\t                       var percentComplete = evt.loaded / evt.total;
\t\t                       // Do something with download progress
\t\t                       percentComplete=percentComplete*100;
\t\t                       percentComplete =Math.round(percentComplete);
\t\t                       \$('#UploadProgressPercent').html(percentComplete);
\t\t                   }
\t\t               }, false);
\t\t               
\t\t               return xhr;
\t\t            },                    
\t\t        url: UploadMediaURL,
\t\t        data: fd,
\t\t        cache: false,
\t\t        processData: false,
\t\t        contentType: false,
\t\t        type: 'POST',
\t\t        success: function (data) {
\t\t            // do something with the result
\t\t            
\t\t            \$(\"#UploadProgressPercentMain\").hide();
\t\t            \$(\"#UploadFileResponseAlt\").hide();
\t\t            \$(\"#UploadFileResponse\").html(data);

\t\t            //clear attached file
\t\t\t        \$(\"#SelectFile\").val(\"\");
\t\t\t        \$(\"#FileNameUpadteText\").html(\"\");
\t\t 
\t\t        }

\t\t    });    
\t\t}

</script>";
    }

    public function getTemplateName()
    {
        return "modules/custom/import_csv/templates/import-csv.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/custom/import_csv/templates/import-csv.html.twig", "C:\\xampp\\htdocs\\Pana_Drupal_Assessment_AB_inBev\\modules\\custom\\import_csv\\templates\\import-csv.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array();
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                [],
                [],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
