/**
 * 打印机封装
 */
var print = {
	d: {
		printersId: '',
	},
	init: function(data){
		var _this = this;
		jQuery.extend(this.d, data);
		
		$.getScript("https://localhost:8443/CLodopfuncs.js", function(){
			if (_this.d.printersId != '') _this.driverSelectList();
		});
	},
	driverSelectList: function () {
      	CLODOP.Create_Printer_List(this.d.printersId, true);
	},
	print: function(content, callback){
		var iDriverIndex = document.getElementById("test").value;
		
		LODOP.PRINT_INIT("测试端桥AO打印");
		LODOP.SET_PRINTER_INDEX(this.d.printersId.value);
		//LODOP.SET_PRINTER_INDEX("\\USER-20170412MC\HP LaserJet 1022");
		LODOP.SET_PRINT_PAGESIZE(0,0,0,"A4");
		LODOP.ADD_PRINT_HTM(30,10,"100%","80%", content);
		if (typeof(callback) != 'undefined') LODOP.On_Return=callback;
		LODOP.PRINT();
		//LODOP.PREVIEW();
	},
	getIPs: function () {
	    var ip_dups = {};

	    var RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
	    var mediaConstraints = {
	        optional: [{
	            RtpDataChannels: true
	        }]
	    };

	    var servers = undefined;

	    if (window.webkitRTCPeerConnection)
	        servers = {
	            iceServers: [{
	                urls: "stun:stun.services.mozilla.com"
	            }]
	        };

	    var pc = new RTCPeerConnection(servers, mediaConstraints);

	    pc.onicecandidate = function (ice) {

	        if (ice.candidate) {

	            var ip_regex = /([0-9]{1,3}(\.[0-9]{1,3}){3})/
	            var ip_addr = ip_regex.exec(ice.candidate.candidate)[1];

	            if (ip_dups[ip_addr] === undefined)
	                callback(ip_addr);

	            ip_dups[ip_addr] = true;
	        }
	    };

	    pc.createDataChannel("");

	    pc.createOffer(function (result) {
	        pc.setLocalDescription(result, function () {});

	    }, function () {});
	}

};