<html>
	<head>
		<title>XML Schema Maker 0.1.1</title>
		<style type='text/css'>
			<!--
			.main{clear:both;width:100%;}
			.head{height:40px;clear:both;background-color:#CCCCFC;padding:3px 3px 3px 3px;}
			.title{float:left;font-size:35px;}
			.panel{float:left;margin-left:5%;}
			.body{clear:both;background-color:#CECECE;}
			-->
		</style>
		<script type='text/javascript' src='/lib/gt/invis.js'></script>
		<script type='text/javascript'>
			<!--
			var Invis=new Invis();
			var elems=[];
			
			var addelem=function(elem,parent)
			{
				var m=document.createElementById("div");
				m.id="item"
			}
			
			var addattr=function(parent)
			{
				var c=document.createElement("div");
				c.id=parent+'_attributes_'+elems[parent]['curr_attr'];
				var el=document.getElementById(parent);
				if(el)
				{
					v	
				}
			}
			-->
		</script>
	</head>
	<body>
		<div class='main'>
			<div class='head'>
				<div class='title'>Insche! 0.1.1</div>
				<div class='panel'>
					<button>Backups</button>
					<button>Settings</button>
				</div>
			</div>
			<div class='body'>
				<div class='left'>
					<ul class='items'>
						<li class='item' id='s1'>
							<div class='data'>
									<div class='ititle'>
										<input type='text' name='s1' value='data'/>
										<input type='checkbox' id='s1_importance' checked/> 
									</div>
									<div class='block' id='s1_attributes' style='display:none;'>
										<h2>Attributes</h2>
											<div class='attr' id='s1_attributes_0'>
												<select name='importance'>
													<option>+</option>
													<option>*</option>
													<option>?</option>
												</select>
												<input type='text' name='name' value='name'/>
												<input type='text' name='value' value='value'/>
												<button>x</button>
											</div>
											<button onclick='addattr("s1");'>add</button>
									</div>
								</div>
								<div class='controls'>
									<button onclick='Invis.tools.changeElVis("s1_childs","switch");return false'>Childs</button>
									<button onclick='Invis.tools.changeElVis("s1_attributes","switch");return false;'>Attributes</button>
								</div>
							</div>
						</li>
						<ul class='items' id='s1_childs' style='display:none;' >
							<li class='item' id='s1'>
								<input type='text' name='s1' value='data'/>
								<div class='controls'>
									<button>Childs</button>
									<button>Attributes</button>
									<button>Importance</button>
								</div>
							</li>
							<li class='item' id='s1'>
								<input type='text' name='s1' value='data'/>
								<div class='controls'>
									<button>Childs</button>
									<button>Attributes</button>
									<button>Importance</button>
								</div>
							</li>
							<li class='item' id='s1'>
								<input type='text' name='s1' value='data'/>
								<div class='controls'>
									<button>Childs</button>
									<button>Attributes</button>
									<button>Importance</button>
								</div>
							</li>
							<li class='item' id='s1'>
								<input type='text' name='s1' value='data'/>
								<div class='controls'>
									<button>Childs</button>
									<button>Attributes</button>
									<button>Importance</button>
								</div>
							</li>
							<ul>
								<li class='item' id='s1'>
									<input type='text' name='s1' value='data'/>
									<div class='controls'>
										<button>Childs</button>
										<button>Attributes</button>
										<button>Importance</button>
									</div>
								</li>
								<li class='item' id='s1'>
									<input type='text' name='s1' value='data'/>
									<div class='controls'>
										<button>Childs</button>
										<button>Attributes</button>
										<button>Importance</button>
									</div>
								</li>
							</ul>
						</ul>
					</ul>
				</div>
				<div class='right'>
					<button>Generate output</button>
					<button>Save</button>
				</div>
			</div>
		</div>
	</body>
</html>