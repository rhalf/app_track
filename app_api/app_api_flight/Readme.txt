Webservice RestApi

Request
	*Parts
		http://184.107.179.181/v1/main/privilege/json/1?api_key=49xSgp6MDZFV3wb2
			1. Port
				-http = Port 80
				-https = Port 443
			2. Ip Address
				-184.107.179.181
				-Can be a domain
			3. Api Version
				-v1, v2
			4. Class
				-privilege
				-user
				-company
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
			8.	Parameter
				api_key=49xSgp6MDZFV3wb2 	:api key for accessing

		*GET
			-	http://184.107.179.181/v1/main/privilege/json?api_key=49xSgp6MDZFV3wb2
				Result:
					{
						"Status":0,
						"Item":1,
						"Message":"SUCCESS",
						"Object":{
									"privilege":
									[	{
											"Id":1,
											"Name":"SUPER",
											"Desc":"System - All",
											"Value":1
										}
									]
								}
					}

			-	http://184.107.179.181/v1/main/privilege/json/1?api_key=49xSgp6MDZFV3wb2
				Result:
					{
						"Status":0,
						"Item":1,
						"Message":"SUCCESS",
						"Object":{
									"privilege":
									[	{
											"Id":1,
											"Name":"SUPER",
											"Desc":"System - All",
											"Value":1
										},
										{
											"Id": 2
											"Name": "POWER"
											"Desc": "Management - All but not updating password and connections"
											"Value": 2
										}
									]
								}
					}

		

