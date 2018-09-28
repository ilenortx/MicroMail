/**
 * 打印机封装
 */
var print = {
	d: {
		ip: 0,
	},
	init: function(data){
		var _this = this;
		//jQuery.extend(this.d, obj);
		//获取客户内网ip
		//this.getIPs(function(ip){ _this.d.ip = ip; });
		//加载js
		//this.loadJs("http://192.168.1.101:8000/CLodopfuncs.js");
	},
	driverSelectList: function (node) {
      	CLODOP.Create_Printer_List(node, true);
	},
	print: function(){
		var iDriverIndex=document.getElementById("test").value;
		
		LODOP.PRINT_INIT("测试端桥AO打印");
		//LODOP.SET_PRINTER_INDEX(iDriverIndex);
		LODOP.SET_PRINTER_INDEX("Microsoft XPS Document Writer");
		LODOP.SET_PRINT_PAGESIZE(0,0,0,"sdfsdf");
		LODOP.ADD_PRINT_TEXT(10,10,300,200,"这是纯文本行");
		LODOP.ADD_PRINT_HTM(30,10,"100%","80%","超文本横线:<hr>下面是二维码:");
		LODOP.ADD_PRINT_BARCODE(85,10,79,69,"QRCode","123456789012");
		LODOP.On_Return=function(TaskID,Value){ alert("打印结果:"+Value); };
		LODOP.PRINT();
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
	},
	/**
     * 动态加载JS
     * @param {string} url 脚本地址
     * @param {function} callback  回调函数
     */
	loadJs: function (url, callback) {
        var head = document.getElementsByTagName('head')[0];
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = url;
        if(typeof(callback)=='function'){
            script.onload = script.onreadystatechange = function () {
                if (!this.readyState || this.readyState === "loaded" || this.readyState === "complete"){
                    callback();
                    script.onload = script.onreadystatechange = null;
                }
            };
        }
        head.appendChild(script);
    }
};