// This is used to ignore orders from an email address we shouldn't claim attribution on
mybuys.base_initPage = mybuys.initPage;
mybuys.initPage = function()
{
	if((this.params["pt"]) && (this.params["pt"].indexOf("purchase") != -1))
	{
		if(this.params['email'])
		{
			var testemail = Math.max(this.params['email'].toUpperCase().indexOf("@DECKERS.COM"),this.params['email'].toUpperCase().indexOf("KEYNOTETEST@GMAIL.COM"));
			if(testemail<0)
			{
				this.base_initPage();
			}
		}
		else
		{
			this.base_initPage();
		}
	}
	else
	{
		this.base_initPage();
	}
}

mybuys.setClient("UGGAUSTRALIAUK");

mybuys.enableZones();

mybuys.setFailOverMsecs(5000);
