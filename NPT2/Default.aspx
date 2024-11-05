<%@ Page Title="Home Page" Language="C#"  AutoEventWireup="true" CodeBehind="Default.aspx.cs" Inherits="NPT2._Default" %>

<html>
    <head>
        <title>xml ja xslt andmete kuvamine</title>
    </head>
    <body>
        <h1>xml ja xslt andmete kuvamine</h1>
        <br />
        <div>
            <asp:Xml runat="server" DocumentSource="~/Nimed.xml"
                TransformSource="~/NimedLisa.xslt" />
        </div>
    </body>
</html>