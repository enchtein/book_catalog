<!-- счетчик для покупки -->
<script>
	function plus() {
		var a = parseInt(document.getElementById('resultcost').value);
		var b = parseInt(document.getElementById('countbooks').value);

		if (isNaN(a)==true) a=0;
		if (isNaN(b)==true) b=0;

		var c = a * (b + 1);

		document.getElementById('result').innerHTML = c;
	}
	function minus() {
		var a = parseInt(document.getElementById('resultcost').value);
		var b = parseInt(document.getElementById('countbooks').value);

		if (isNaN(a)==true) a=0;
		if (isNaN(b)==true) b=0;

		var c = a * (b + 1);
		
			if (b==1) {
			var d = c-a;
			document.getElementById('result').innerHTML = d;
		
			} else {
			var d = c-a-a;
		document.getElementById('result').innerHTML = d;
			}
	}
</script>
<!-- /счетчик для покупки -->