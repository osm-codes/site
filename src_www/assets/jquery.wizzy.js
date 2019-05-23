/**
 * Wizzy jQuery plugin, original from https://github.com/NenadKaevik/wizzy
 */

var wizzy; // wasy to assign a globsl variable to a plugin, see https://stackoverflow.com/q/15056400

(function($){
    wizzy = $.fn.wizzy = function(options) {
       let settings = $.extend({
        //lixo wizzy.settings = $.extend({
             stepNumbers:  false
            ,progressType: 'fill'
            ,tplId:        false//'wzTpl'
            ,tplSecs:      "section[lang='en']"
            ,minimalWinSize: 380
        }, options);

        return this.each(function(){
            wizzy.settings = settings; // funciona?
            let elem = $(this);
            let nav = elem.find('.wz-header nav');
            let navigator = elem.find('.wz-navigator');
            let content = elem.find('.wz-inner');

            // changed from js-font (fas) to css-font (fa):
            let btnNext  = '<a href="#" class="btn btn-primary right" data-action="next">Próximo <i class="fa fa-angle-right"></i></a>';
            let btnBack  = '<a href="#" class="btn btn-default left" data-action="back"><i class="fa fa-angle-left"></i> Anterior</a>';
            let btnFinish = '<a href="#" class="btn btn-success right" data-action="finish">Feito! <i class="fa fa-check"></i></a>';

            let step_content;
            wizzy.step = 0;  // new, important to external access

            // new change:
            let sizeMini = $(window).width() < wizzy.settings.minimalWinSize; // please check in the settings.tplId==true condiction.
            if (settings.tplId) {
              step_content = $('aside.wizzy section.wz-body'); // only the DOMnode.
              wizzy.tpl = document.querySelector('#'+wizzy.settings.tplId);
              wizzy.tplSecs = wizzy.tpl.content.querySelectorAll(wizzy.settings.tplSecs); // e.g. tplSecs = "section"
              wizzy.tplTitles = [...wizzy.tplSecs].map(x => x.dataset.shortTitle);
              //console.log( "DEBUG2:",wizzy.tplSecs.length,  wizzy.tplSecs[0].constructor, wizzy.tplTitles, wizzy.tplSecs[0] instanceof HTMLElement )
            } else {  // no template tag
              settings.tplId=false;
              step_content = elem.find('.wz-step').toArray();  // a sequence of DOMNodes.
              wizzy.tplTitles = step_content.map(x => x.dataset.shortTitle);
            }

            if (wizzy.tplTitles.length>1) {  // config by tplTitles from data-short-title
              for(i of wizzy.tplTitles)
                nav.append('<a href="#">'+i+'</a>')
              var step_links = elem.find('nav a').toArray(); // please check in the settings.tplId==true condiction.
              var step_count = step_links.length;
              var step_status = new Array(step_count);
              var link_width = $(step_links[0]).width(); // need reacalc on event, see https://api.jquery.com/resize/
            } else { // config by direct nav items! (like original Wizzy)
              var step_links = elem.find('nav a').toArray(); // please check in the settings.tplId==true condiction.
              if (step_links.length>1) {
                var step_links = elem.find('nav a').toArray(); // please check in the settings.tplId==true condiction.
                wizzy.tplTitles = step_links;
                var step_count = step_links.length;
                var step_status = new Array(step_count);
                var link_width = $(step_links[0]).width(); // need reacalc on event, see https://api.jquery.com/resize/
              } else
                throw new Error('ERROR: no list, use data-short-title attribute or direct list at wz-header');
            }

            function init(){
                if (sizeMini)
                  $('aside.wizzy').prepend('<p class="wz-tit" align="center">Passo 1. Basic </p>')
                for(i = 1 ; i < step_count ; i++){
                    step_status[i] = 0;
                }
                step_status[0] = 1;
                updateTemplate();
                render();
            }

            function moveProgress(step){
                if(wizzy.settings.progressType == 'fill'){
                    let progressWidth = link_width * (step + 1);
                    nav.find('.progress').css({'width':progressWidth + 'px'});
                }
                if(wizzy.settings.progressType == 'slide'){
                    nav.find('.progress').css({'width':link_width + 'px'});
                    let distance = link_width * (step);
                    nav.find('.progress').css({'left':distance + 'px'});
                }

            }

            function updateTemplate(){
                nav.append('<div class="progress"></div>');
                moveProgress(wizzy.step);
                step_links.forEach(element => {
                    $(element).wrapInner('<span></span>');
                });
            }

            /**
             *
             * @param {boolean} show
             */
            function loader(show){
                let loader ='<div class="loading"></div>';
                if(show === true){ //Show Loader Spinner
                    content.fadeOut(400,function(){
                        elem.addClass('progress');
                        setTimeout(() => {
                            elem.append(loader);
                        }, 500);
                    });
                }
                else{
                    elem.find('.loading').remove();
                    elem.removeClass('progress');
                    setTimeout(() => {
                        content.fadeIn(400);
                    }, 400);
                }
            }

            /**
             *
             * @param {string} action
             */
            function react(action){
                if(wizzy.step >= 0 && wizzy.step < step_count){
                    if(action === 'next'){
                        step_status[wizzy.step++] = 1;
                        if(step_status[wizzy.step] === 0){
                            step_status[wizzy.step] = 1;
                        }
                        render(wizzy.step);
                    }
                    else if(action == 'back'){
                        wizzy.step--;
                        render(wizzy.step);
                    }
                    else if(action == 'finish'){
                      //  old effect:
                      //loader(true); setTimeout(() => { loader(false); }, 3000);
                    }
                }
            }

            /**
             * Render out the content
             */
            function render(){
                navigator.html('');

                if(wizzy.step === 0){
                    navigator.append(btnNext);
                }
                else if(wizzy.step === step_count-1){
                    navigator.append(btnBack + btnFinish);
                }
                else{
                    navigator.append(btnBack + btnNext);
                }

                elem.find('nav a').removeClass('active completed')
                //elem.find('nav a:nth-child('+wizzy.step+') span').html(stepGenLabel);
                //console.log(  elem.find('nav a').html());
                // elem.find('nav a span').each(html('passo '+wizzy.step));

                for(let i = 0 ; i < wizzy.step ; i++)
                    $(step_links[i]).addClass('completed'); // old
                //let lang='en'
                var daVezLabel='';
                for(let i = 0 ; i < step_count ; i++){ // new
                    let n= i+1;
                    if (i==wizzy.step)
                      daVezLabel = n+". " + wizzy.tplTitles[i]
                    let label = (!sizeMini && i==wizzy.step)? daVezLabel: ('&#160;&#160; ('+n+') &#160;&#160;')
                    $(step_links[i]).find('span').html(label);
                }
                if (sizeMini)
                  $('aside.wizzy p.wz-tit').html("Passo "+daVezLabel);
                $(step_links[i]).addClass('active');
                if (settings.tplId) {
                  // HERE, need to change jQuery to DOM replace!
                  step_content.html( wizzy.tplSecs[wizzy.step].innerHTML )
                  // the best is to repalce DOM, not strings: https://api.jquery.com/replaceWith/
                } else {
                  elem.find('.wz-body .wz-step').removeClass('active');
                  $(step_content[wizzy.step]).addClass('active');
                }
                moveProgress(wizzy.step);
            }

            /**
             * Click events
             */
            $(elem).on('click','.wz-navigator .btn',function(e){
                e.preventDefault();
                let action = $(this).data('action');
                react(action);
            });

            $(elem).on('click','nav a',function(e) {
                e.preventDefault();
                let step_check = $(this).index();
                console.log(wizzy.step,'anterior:',step_check);
                //if(step_status[step_check] === 1 || step_status[step_check] === 2){
                if((wizzy.step+1)==step_check||step_check<wizzy.step){
                    wizzy.step = step_check; //$(this).index();
                    render();
                }
                else{
                    // click in advance
                    alert("Clique no botão 'PRÓXIMO'");
                    console.log('Invalid click, or check errors');
                }
            });


            init();
        });
    }

}(jQuery));
