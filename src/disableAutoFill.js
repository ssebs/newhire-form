(function(t){var i=[],e=[],n={};n.passwordListener=function(e,n){var a=""==n.passwordFiled?".disabledAutoFillPassword":n.passwordFiled;e.find("[type=password]").length>0&&e.find("[type=password]").attr("type","text").addClass("disabledAutoFillPassword"),t(a).on("keyup",function(){for(var e=t(this).val(),n=e.length,a=0;a<n;a++)"*"!=e[a]&&(i[a]=e[a]);i=i.slice(0,n),t(this).val(e.replace(/./g,"*"))})},n.formSubmitListener=function(i,e){var a=""==e.submitButton?".disableAutoFillSubmit":e.submitButton;t(a).on("click",function(t){n.restoreInput(i,e),e.callback.call()&&(e.debugMode?console.log(i.serialize()):i.submit()),e.randomizeInputName&&n.randomizeInput(i,e),n.passwordListener(i,e)})},n.randomizeInput=function(i,n){i.find("input").each(function(i){e[i]=t(this).attr("name"),t(this).attr("name",Math.random().toString(36).replace(/[^a-z]+/g,""))})},n.restoreInput=function(n,a){a.randomizeInputName&&n.find("input").each(function(i){t(this).attr("name",e[i])}),a.textToPassword&&t(a.passwordFiled).attr("type","password"),t(a.passwordFiled).val(i.join(""))},t.fn.disableAutoFill=function(i){var e=t.extend({},t.fn.disableAutoFill.defaults,i);this.find("[type=submit]").length>0&&this.find("[type=submit]").attr("type","button").addClass("disableAutoFillSubmit"),e.randomizeInputName&&n.randomizeInput(this,e),n.passwordListener(this,e),n.formSubmitListener(this,e)},t.fn.disableAutoFill.defaults={debugMode:!1,textToPassword:!0,randomizeInputName:!0,passwordFiled:"",submitButton:"",callback:function(){return!0}}})(jQuery);