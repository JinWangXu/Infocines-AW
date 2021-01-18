(function($) {

    var slide = function(ele, num) {
        var $ele = $(ele);

        var setting = {

            speed: 1000,

            interval: 2000,
            
        };
        if(num == 1){
            
            var states = [
                { $zIndex: 1, width: 224, height: 288, top: 0, left: 0, $opacity: 1 }
            ];
    
        }
         if(num == 2){
            var states = [
                { $zIndex: 1, width: 224, height: 288, top: 0, left: 0, $opacity: 1 },
                { $zIndex: 2, width: 224, height: 288, top: 0, left: 250, $opacity: 1 }
            ];
    
        }
         if(num == 3){
            
            var states = [
                { $zIndex: 1, width: 224, height: 288, top: 0, left: 0, $opacity: 1 },
                { $zIndex: 2, width: 224, height: 288, top: 0, left: 250, $opacity: 1 },
                { $zIndex: 3, width: 224, height: 288, top: 0, left: 500, $opacity: 1 }
            ];

        }
         if(num == 4){
             
            var states = [
                { $zIndex: 1, width: 224, height: 288, top: 0, left: 0, $opacity: 1 },
                { $zIndex: 2, width: 224, height: 288, top: 0, left: 250, $opacity: 1 },
                { $zIndex: 3, width: 224, height: 288, top: 0, left: 500, $opacity: 1 },
                { $zIndex: 4, width: 224, height: 288, top: 0, left: 750, $opacity: 1 }
            ];
    
        }
        else{
            var rest = num - 4;
        
        
        var states = [
            { $zIndex: 1, width: 224, height: 288, top: 0, left: 0, $opacity: 1 },
            { $zIndex: 2, width: 224, height: 288, top: 0, left: 250, $opacity: 1 },
            { $zIndex: 3, width: 224, height: 288, top: 0, left: 500, $opacity: 1 },
            { $zIndex: 4, width: 224, height: 288, top: 0, left: 750, $opacity: 1 }
            
        ];
        for(var i = 0;  i > rest ; i++){
        states[states.length] = { $zIndex: 0, width: 224, height: 288, top: 0, left: 0, $opacity: 0 };
        }
      }
        var $lis = $ele.find('li');
        var timer = null;

        $ele.find('.hi-next').on('click', function() {
            states.push(states.shift());
            move();

        });
        $ele.find('.hi-prev').on('click', function() {
            next();
        });
        move();
        function move() {
            $lis.each(function(index, element) {
                var state = states[index];
                $(element).css('zIndex', state.$zIndex).finish().animate(state, setting.speed).find('img').css('opacity', state.$opacity);
            });
        }

        function next() {

            states.unshift(states.pop());
            move();
        }
    }

    $.fn.hiSlide = function(num) {
        $(this).each(function(index, ele) {
            slide(ele,num);
        });

        return this;
    }
})(jQuery);
