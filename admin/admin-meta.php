<title>PageDown Demo Page</title>
  <base href="http://hopper.wlu.ca/~rodu4140/test/" target="_blank">
  <link rel="stylesheet" type="text/css" href="admin/demo.css" />
        
  <script type="text/javascript" src="static/js/Markdown.Converter.js"></script>
  <script type="text/javascript" src="static/js/Markdown.Sanitizer.js"></script>
  <script type="text/javascript" src="static/js/Markdown.Editor.js"></script>
  <!-- Must happen in this order! -->
	<script type="text/x-mathjax-config;executed=true">
  MathJax.Hub.Config({
    showProcessingMessages: false,
    tex2jax: { inlineMath: [['$','$'],['\\(','\\)']] }
  });
	</script>	
	<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
  <script type="text/javascript" src="static/js/mathjax-editing.js"></script>
  <!-- End -->
  <link  type="text/css" rel="stylesheet" href="static/css/style.css"/>
  <style>
  #header{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 2em;
    background-color: #000;
    z-index: 10;
  }
  #sidebar{
    position: fixed;
    top: 2em;
    width: 200px;
    height: 100%;
    background-color: #333;
    z-index: 10;
  }
  #wrapper{
    margin-top: 2em;
    margin-left: 200px;
    padding: 20px;
    min-width: 640px;
    -webkit-box-shadow: inset 5px 5px 10px rgba(0,0,0,0.5);
    box-shadow: inset 2px 2px 5px rgba(0,0,0,0.5);
    
  }
  .wmd-panel{
    margin: 0;
    patting: 0;
  }
  .input{
    border-radius: 3px;
    border: 1px solid #aaa;
    min-width: 640px;
    width: 100%;
    max-width: 100%;
    min-height: 300px;
  }
  
  .output{
    min-width: 640px;
    widsth: 100%;
    max-width: 100%;
    min-height: 300px;
  }
  blockquote{
    margin: 20px 0;
    padding: 20px 20px 10px;
    border-left: 3px solid #444;  
    background-color: #eee;
  }
  blockquote > blockquote{
    margin: 0;
    padding: 10px 10px 0;
  }
  input{
    min-width: 640px;
    width: 100%;
    max-width: 100%;
    font-size: 1.5em;
    padding: 5px 2px;
    border-radius: 3px;
    border: 1px solid #aaa;
  }
  code{
    font-family: Menlo,Monaco,Consolas,"Courier New",monospace;
  }
  pre{
    margin: 20px 0;
    padding: 20px;
    border-left: 3px solid #5bc0de;;  
    background-color: #f4f8fa;
  }
  del{
    text-decoration: line-through;
    color: #ff0000;
  }
  ul li{
    list-style: circle outside;
    margin-left: 20px;
  }
  ol li{
    list-style: decimal outside;
    margin-left: 20px;
  }
  ul, ol{
    display: block;
    margin: 10px 0;
  }
  </style>