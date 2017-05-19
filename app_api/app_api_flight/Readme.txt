Webservice RestApi

Features
	-Uses FlightPhp framework.
	-Supports standard crud request.
	-Provides a clear status response.
	-Supported all platforms, browsers and devices.
	-Designed in object oriented approach for each
	 updating, patching and managing source code.


Request Mapping
	*Parts
		http://184.107.175.155/v1/main/privilege/json/1?api_key=49xSgp6MDZFV3wb2
			1. Port
				-http = Port 80
				-https = Port 443
			2. Ip Address
				-184.107.175.155
				-Can be a domain
			3. Api Version
				-v1, v2
			4. Class
				-privilege
				-user
				-company
				-etc...
			5.	Database or Source
				-main 
				-data
				-report
			6.	Format
				-json
				-xml
			7. Id (Optional)
				-1,2...
				-If empty then selects all
			8.	Parameter(disabled as of this moment)
				api_key=49xSgp6MDZFV3wb2 	:api key for accessing

		*GET
			-	http://184.107.175.155/v1/main/privilege/json?api_key=49xSgp6MDZFV3wb2
		
			-	http://184.107.175.155/v1/main/privilege/json/1?api_key=49xSgp6MDZFV3wb2
			

Requirements
	-Mysql Database with app_database installed.
	-Php Manager
	-IIS8
	-Php 5.6

Procedure
	-Copy this api to a server of your wish and put inside a folder, rename the folder to "app_api".
	-Open iis8 and create new website.
	-Direct the path into the api's folder "../../app_api".
	-Set the ip and port you want "184.107.175.154".
	-Restart iis then test the GET command "http://184.107.175.155/v1/main/privilege/".


To enable http verbs:
	-Goto C:\Windows\System32\inetsrv\config\applicationHost.config
	-Add verbs
	
		<location path="app_api">
	        <system.webServer>
	            <handlers accessPolicy="Read, Execute, Script">
	                <clear />
	                <add name="PHP_via_FastCGI4" path="*.php" verb="GET,POST,PUT,DELETE,OPTIONS" modules="FastCgiModule" scriptProcessor="C:\Program Files (x86)\PHP\v5.6\php-cgi.exe" resourceType="Either" />
	                <add name="PHP_via_FastCGI3" path="*.php" verb="GET,POST,PUT,DELETE,OPTIONS" modules="FastCgiModule" scriptProcessor="C:\Program Files\iis express\PHP\v7.0\php-cgi.exe" resourceType="Either" />
	                <add name="PHP_via_FastCGI2" path="*.php" verb="GET,POST,PUT,DELETE,OPTIONS" modules="FastCgiModule" scriptProcessor="C:\Program Files (x86)\iis express\PHP\v5.6\php-cgi.exe" resourceType="Either" />
	                <add name="PHP_via_FastCGI1" path="*.php" verb="GET,POST,PUT,DELETE,OPTIONS" modules="FastCgiModule" scriptProcessor="C:\Program Files (x86)\iis express\PHP\v7.0\php-cgi.exe" resourceType="Either" />
	                <add name="PHP_via_FastCGI" path="*.php" verb="GET,POST,PUT,DELETE,OPTIONS" modules="FastCgiModule" scriptProcessor="C:\Program Files\PHP\v7.0\php-cgi.exe" resourceType="Either" />
	                <add name="PHP53_via_FastCGI" path="*.php" verb="GET,POST,PUT,DELETE,OPTIONS" modules="FastCgiModule" scriptProcessor="C:\Program Files (x86)\PHP\v5.3\php-cgi.exe" resourceType="Either" />
	                <add name="CGI-exe" path="*.exe" verb="*" modules="CgiModule" resourceType="File" requireAccess="Execute" allowPathInfo="true" />
	                <add name="TRACEVerbHandler" path="*" verb="TRACE" modules="ProtocolSupportModule" requireAccess="None" />
	                <add name="OPTIONSVerbHandler" path="*" verb="OPTIONS" modules="ProtocolSupportModule" requireAccess="None" />
	                <add name="StaticFile" path="*" verb="*" modules="StaticFileModule,DefaultDocumentModule,DirectoryListingModule" resourceType="Either" requireAccess="Read" />
	            </handlers>
	        </system.webServer>
	    </location>


		1000000010000000

