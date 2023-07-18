<?php 
 /**
  * The homepage template
  * */

$path = preg_replace('/wp-content.*$/','',__DIR__);
include($path.'wp-load.php'); 
get_header( 'vue-custom' ); ?>

<div id="app">
	<div class="main container home">
		<div class="section section1">
			
			<div class="col col1">
				<h1>
					This is a placeholder title
				</h1>
				<h4>
					And this is the placeholder sub
				</h4>
				
			</div>

			<div class="col col2">
				<img class="bgr-dynamic" src="/wp-content/uploads/2023/07/texture2.webp">
			</div>			
			
		</div>
	</div>	
</div>












<?php get_footer( 'vue-custom' ); ?>




<script>

var app = new Vue({
  el: '#app',
  data: {
    variable1: null,
    variable2: null,
    apiData: []
  },
  mounted: function() {
	fetch('https://hplussport.com/api/products/order/price')
	  .then(response => response.json())
	  .then(data => {
	  	this.apiData = data;
	  })
	}
});

</script>