<?xml version='1.0' encoding='utf-8'?>
<xsl:stylesheet type='text/xsl' version='2.0' xmlns:xsl='http://www.w3.org/1999/xslt'>
	
	<!--META-INFO templates-->
	
	<xsl:template name='metas'>
	</xsl:template>
	
	<xsl:template name='rss'>
	</xsl:template>
	
	<xsl:template name='javascript'>
	</xsl:template>
	
	<xsl:template name='css'>
	</xsl:template>
	
	
	<!--PAGE-STRUCTURE templates-->
	
	<xsl:template name='left'>
	</xsl:template>
	
	<xsl:template name='right'>
	</xsl:template>
	
	<xsl:template name='center'>
	</xsl:template>
	
	<xsl:template name='info'>
			<xsl:apply-templates name='metas'/>
			<xsl:apply-templates name='css'/>
			<xsl:apply-templates name='rss'/>
			<xsl:apply-templates name='javascript'/>
	</xsl:template>
	
	<xsl:template name='body'>
		<div id="maincontent">
			<div id='left'>
				<xsl:apply-templates name='left'/>
			</div>
			<div class='content'>
				<xsl:apply-templates name='center'/>
			</div>
			<div id='right'>
				<xsl:apply-templates name='right'/>
			</div>
		</div>
	</xsl:template>
	
	<xsl:template match='/'>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
			<head id='head'>
				<xsl:apply-templates name='info'/>
			</head>
			<!--TODO: probably need to use customizable tags body-->
			<body id='body'>
				<div id='doc'>
					<div id='top'><xsl:apply-templates name='pagetop'/></div>
					<div id="content"><xsl:apply-templates name='body'/></div>
					<div id='footer'><xsl:apply-templates name='footer'/></div>
					<div id="bottom"><xsl:apply-templates name='bottom'/></div>
				</div>
			</body>
		</html>
	</xsl:template>