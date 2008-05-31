			var loading=null;
			Invis.setPath('http://'+window.location.host);
			var dInit=function(e)
			{
				if (!Invis.browser.IE) {
					Invis.modules.loadInit("basket", "functions");
					Invis.modules.loadInit("maillist", "functions");
				}
				finishLoading((!Invis.browser.IE)?function(e){
					Invis.tools.loadLib("js", "/lib/gt/opera-invite.js", "opera-invite");
				}:null);
				return true;
			}
			var changeLang=function()
			{
				window.location.href="/lang/"+document.getElementById('lngField').value;
			}
			var changeImage=function(id,src)
			{
				document.getElementById(id).src=Invis.getPath()+'/images/'+src;
			}
			var rollInit=function(id,base,change)
			{
				var el=document.getElementById(id);
				if(el)
				{
					el.onmouseover=changeImage.bind(changeImage,id,change);
					el.onmouseout=changeImage.bind(changeImage,id,base);
				}
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
			var initL=function()
			{
				if (Invis.browser.Opera) {
					var l=document.createElement("div")
					l.setAttribute("style","display:block;");
					l.innerHTML += "<div id='loading_bar' style='margin-top:15%;width:100%;height:100%;display:block;'><img src='/images/logo.png' style='margin-left:34%;'/>";
					l.innerHTML += "<h3 style='text-align:center;color:#FFFFFF;border:2px #999999 dashed;border-left-width:0px;border-right-width:0px;width:100%;background-color:#CCCCCC;'>Загрузка, ожидайте несколько секунд...</h3>";
					l.innerHTML += "<img src='/images/logo.png' style='margin-left:34%;'/></div>";
					document.documentElement.appendChild(l);
				}
			}