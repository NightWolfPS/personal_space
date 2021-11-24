function ChatLoaderFunc(chatroomID){
    var username = '';
    var ExId = '';
    var avatar = '';
    var signature ='';

    /* Chatbro Widget Embed Code Start */
    function ChatbroLoader(chats, async) {
        async = !1 !== async;
        var params = {
            embedChatsParameters: chats instanceof Array ? chats : [chats],
            lang: navigator.language || navigator.userLanguage,
            needLoadCode: 'undefined' == typeof Chatbro,
            embedParamsVersion: localStorage.embedParamsVersion,
            chatbroScriptVersion: localStorage.chatbroScriptVersion
        },
        xhr = new XMLHttpRequest;
        xhr.withCredentials = !0;
        xhr.onload = function() {
            eval(xhr.responseText);
        };
        xhr.onerror = function() {
            console.error('Chatbro loading error')
        };
        xhr.open('GET', '//www.chatbro.com/embed.js?' +
            btoa(unescape(encodeURIComponent(JSON.stringify(params)))), async);
        xhr.send();
    }
    /* Chatbro Widget Embed Code End */
    $.ajax({
        url: "php/db.php", 
        type: "POST",
        data: {user:'user'},
        dataType: "json", 
        success: function(result) {
            if (!result.error){
                username = result.username;
                ExId = result.ExId;
                avatar = result.avatar;
                signature = result.signature;
                console.log('Name: ' + username + '\nExId: ' + ExId + '\navatar: ' + avatar);
                
                ChatbroLoader({
                    encodedChatId: chatroomID,
                    siteDomain: 'http://localhost/public_html/chat.php', 
                    siteUserExternalId: ExId, 
                    siteUserFullName: username,
                    permissions: ['delete'],
                    // siteUserFullNameColor: Цвет для имени пользователя, 
                    siteUserAvatarUrl: avatar, 
                    siteUserProfileUrl: 'profile.php?user=' + username,
                    signature: signature,
                });
            }
            else{
                return false;
            }
        }
    });
}