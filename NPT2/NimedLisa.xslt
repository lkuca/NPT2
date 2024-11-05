<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:msxsl="urn:schemas-microsoft-com:xslt" exclude-result-prefixes="msxsl"
>
    <xsl:output method="xml" indent="yes" encoding="utf-8"/>

    <xsl:template match="/">
		<dim1>
		<dim2>
		<dim3>
		<table style="border:solid 1px black;">
			<tr>
				<th style="border:solid 1px black;">id</th>
				<th style="border:solid 1px black;">nimi</th>
				<th style="border:solid 1px black;">sugu</th>
				<th style="border:solid 1px black;">emakeelne nimi</th>
				<th style="border:solid 1px black;">võõrkeelne nimi</th>
			</tr>
			<xsl:for-each select="Nimed/Nimed1">
				<tr>
					<xsl:attribute name="style">
						<xsl:choose>
							<xsl:when test="position() mod 2 = 1">
								<xsl:text>background-color: #d3e3d7;</xsl:text>
							</xsl:when>
							<xsl:otherwise>
								<xsl:text>background-color: #ffffff;</xsl:text>
							</xsl:otherwise>
						</xsl:choose>
					</xsl:attribute>
					<td style="border:solid 1px black;">
						<xsl:value-of select="id"/>
					</td>
					<td style="border:solid 1px black;">
						<xsl:value-of select="first_name"/>
					</td>
					<td style="border:solid 1px black;">
						<xsl:value-of select="gender"/>
					</td>
					<td style="border:solid 1px black;">
						<xsl:value-of select="emakeelne_nimi"/>
					</td>
					<td style="border:solid 1px black;">
						<xsl:value-of select="võõrkeelne_nimi"/>
					</td>
				</tr>
			</xsl:for-each>
		</table>
		</dim3>
		</dim2>
		</dim1>
    </xsl:template>
</xsl:stylesheet>
