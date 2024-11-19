<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:msxsl="urn:schemas-microsoft-com:xslt" exclude-result-prefixes="msxsl"
>
    <xsl:output method="xml" indent="yes" encoding="utf-8"/>

    <xsl:template match="/">
		<input type="text" id="searchInput" placeholder="Search name" onkeyup="searchTable()" maxlength="2"/>
        <table style="border:solid 1px black;" data-order="asc" id="searchResults">
            <tr>
                <th style="border:solid 1px black;">id</th>
                <th style="border:solid 1px black;">nimi</th>
                <th style="border:solid 1px black;">emakeelne nimi</th>
                <th style="border:solid 1px black;">võõrkeelne nimi</th>
                <th style="border:solid 1px black;" class="sortable" onclick="sortTable(4)">populaarne</th>
                <th style="border:solid 1px black;" class="sortable" onclick="sortTable(5)">riik</th>
                <th style="border:solid 1px black;" class="sortable" onclick="sortTable(6)">sugu</th>
            </tr>
            <xsl:for-each select="Nimed/inimene">
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
                        <xsl:value-of select="populaarne/riik/gender/id"/>
                    </td>
                    <td style="border:solid 1px black;">
                        <xsl:value-of select="populaarne/riik/gender/first_name"/>
                    </td>
                    
                    <td style="border:solid 1px black;">
                        <xsl:value-of select="populaarne/riik/gender/emakeelne_nimi"/>
                    </td>
                    <td style="border:solid 1px black;">
                        <xsl:value-of select="populaarne/riik/gender/võõrkeelne_nimi"/>
                    </td>
                    <td style="border:solid 1px black;">
                        <xsl:value-of select="populaarne/@nimi"/>
                    </td>
                    <td style="border:solid 1px black;">
                        <xsl:value-of select="populaarne/riik/@nimi"/>
                    </td>
                    <td style="border:solid 1px black;">
                        <xsl:value-of select="populaarne/riik/gender/@nimi"/>
                    </td>
                </tr>
            </xsl:for-each>
        </table>
		<div id="popularName"></div>
    </xsl:template>
</xsl:stylesheet>