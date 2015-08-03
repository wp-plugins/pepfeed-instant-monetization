(function() {
    tinymce.create('tinymce.plugins.pepfeed', {
        init : function(ed, url) {
            ed.addButton('pepfeed', {
                title : 'PepFeed button',
                image : url+'/pepfeed-logo.png',
                onclick : function() {
                    idPattern = /(?:(?:[^v]+)+v.)?([^&=]{11})(?=&|$)/;
                    //var vidId = prompt("YouTube Video", "Enter the id or url for your video");
                    //var m = idPattern.exec(vidId);
                    //if (m != null && m != 'undefined')
                    ed.execCommand('mceInsertContent', false, '[pepfeed-button]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "PepFeed Shopping Assistant",
                author : 'PepFeed',
                authorurl : 'http://pepfeed.com/',
                infourl : 'http://pepfeed.com/',
                version : "0.1"
            };
        }
    });
    tinymce.PluginManager.add('pepfeed', tinymce.plugins.pepfeed);
})();
