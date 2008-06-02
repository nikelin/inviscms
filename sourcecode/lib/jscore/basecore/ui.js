			var loading=null;
			Invis.setPath('http://'+window.location.host);
			var dInit=function(e)
			{
				finishLoading(null);
				return true;
			}
			var changeLang=function()
			{
				window.location.href="/lang/"+document.getElementById('lngField').value;
			}
			var finishLoading=function(after_loading)
			{
				if (Invis.browser.Opera) {
					document.body.style.display = 'block';
					document.getElementById('loading_bar').style.display = "none";
				}
				else 
					document.getElementById('body').style.display = 'block';
				
				if(after_loading)
					after_loading();
			}