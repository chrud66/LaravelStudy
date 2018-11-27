require('../bootstrap');

$(document).ready(function () {
    var $menubar = $('.admin-menubar');
    var $dim = $('.dim');

    /* 사이드바 */
    $menubar.on('admin.menubar.open', function () {
        $menubar.addClass('open');
        $dim.show();
        $('body').css('overflow', 'hidden');
        $('html').css('position', 'fixed');
    }).on('admin.menubar.close', function () {
        $menubar.removeClass('open');
        $dim.hide();
        $('body').css('overflow', '');
        $('html').css('position', '');
    }).on('admin.menubar.toggle', function () {
        if ($(window).innerWidth() < 1068) {
            if ($menubar.hasClass('open')) {
                $menubar.trigger('admin.menubar.close');
            } else {
                $menubar.trigger('admin.menubar.open');
            }
        } else {
            $('body').toggleClass('sidebar-collapse');
        }
    });

    $dim.on('click', function () {
        $menubar.trigger('admin.menubar.close');
    });

    $('.btn-slide').on('click', function () {
        $menubar.trigger('admin.menubar.toggle');
    });
    /* 사이드바 */


    $('.snb-list li a, .snb-list li button').click(function (event) {
        subMenuOnOff(event);
    });
});

var subMenuOnOff = function (event) {
    var $target = $(event.target);
    var $subDepth = $target.parents('.sub-depth:first');
    var $ul = $subDepth.find('.sub-depth-list:first');

    if ($ul.length === 0) {
        return true;
    }

    if ($subDepth.hasClass('open')) {
        $ul.find('.sub-depth-list').slideUp('fast');
        $ul.find('.sub-depth').removeClass('open');

        $ul.slideUp('fast');
        $subDepth.removeClass('open');
    } else {
        $ul.slideDown('fast');
        $subDepth.addClass('open');
    }

    return false;
};