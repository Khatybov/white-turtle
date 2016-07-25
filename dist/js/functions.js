(function ($, globalVars) {

    //sidebar
    (function () {

        //Sub Menu inside
        function SubMenu() {
            //selector names
            var sn = {
                button: 'show-sub-menu',
                buttonActive: 'show-sub-menu-active',
                wrapper: 'showing-sub-menu',
                wrapperActive: 'showing-sub-menu-active'
            };

            //button html
            var button = '' +
                '<button class="' + sn.button + '">' +
                '<span class="genericon"></span>' +
                '</button>';

            //Add sub menu in container and search sub menu by subMenuSelector
            function add(container, subMenuSelector) {
                container.find('.' + subMenuSelector)
                    .before(button)
                    .parent()
                    .addClass(sn.wrapper)
            }

            //deactivate sub menu. It means turn of one
            function deactivate(wrapper) {
                wrapper.removeClass(sn.wrapperActive);
                wrapper.children('.' + sn.button).removeClass(sn.buttonActive);
            }

            //activate sub menu. Turn on
            function activate(wrapper) {
                wrapper.addClass(sn.wrapperActive);
                wrapper.children('.' + sn.button).addClass(sn.buttonActive);
            }

            //turn of all sub menus in container
            function reset(container) {
                deactivate(container.find('.' + sn.button).parent());
            }

            //click handler
            function click(button) {
                var wrapper = button.parent();
                if (wrapper.hasClass(sn.wrapperActive)) {
                    //if closing sub menu, all children sub menus turning off
                    wrapper
                        .find('.' + sn.wrapperActive)
                        .each(function () {
                            deactivate($(this));
                        });

                    deactivate(wrapper);
                } else {
                    activate(wrapper);
                }
            }

            //public properties and methods for use
            this.button = '.' + sn.button;
            this.add = add;
            this.reset = reset;
            this.click = click;

        }

        //Sub menu Top
        function SubMenuTop(whereMenuIs, menuContainerAppendTo, addSubMenu) {

            //selector names
            var sn = {
                wrapper: 'sub-menu-top',
                wrapperActive: 'sub-menu-top-active',
                menuContainer: 'sub-menu-container',
                menuContainerActive: 'sub-menu-container-active',
                itemHasChildren: 'menu-item-has-children'
            };

            //icon with array
            var icon = '<span class="genericon"></span>';

            //container menu, where menu will be cloned
            var menuContainerHtml = '<ul class="' + sn.menuContainer + '"></ul>';

            //append menu
            menuContainerAppendTo.append(menuContainerHtml);

            //Take the container by jQuery
            var menuContainer = $('.' + sn.menuContainer);

            //take menu items with sub menu
            var items = whereMenuIs.children('.' + sn.itemHasChildren);

            //add class to items and insert button with icon
            items
                .addClass(sn.wrapper)
                .children('a')
                .append(icon);

            //close the sub menu
            function close() {

                items.each(function () {
                    var item = $(this);

                    if (item.hasClass(sn.wrapperActive)) {
                        item.removeClass(sn.wrapperActive);
                    }
                });

                menuContainer.removeClass(sn.menuContainerActive).html('');
            }

            //open the sub menu
            function open(button) {
                button.parent().addClass(sn.wrapperActive);

                var selfLink = '<li class="sub-menu-top-parent-link">' +
                    '<a href="' + button.attr('href') + '">' +
                    button.text().replace(icon, '') +
                    '</a></li>';


                menuContainer
                    .addClass(sn.menuContainerActive)
                    .html(selfLink)
                    .append(button.next().children().clone());

                addSubMenu(menuContainer, 'sub-menu');
            }

            //click handler
            function click(button) {
                if (!button.parent().hasClass(sn.wrapperActive)) {
                    close();
                    open(button);
                } else {
                    close();
                }
            }

            //public properties and methods
            this.wrapper = '.' + sn.wrapper;
            this.click = click;
            this.close = close;
        }

        //Mobile menu
        function MobileMenu(whereMenuIs, whereButtonAppendTo, whereMenuAppendTo) {
            //selector names
            var sn = {
                button: 'show-mobile-menu',
                buttonHidden: 'show-mobile-menu-hidden',
                buttonActive: 'show-mobile-menu-active',
                container: 'mobile-menu-container',
                containerActive: 'mobile-menu-container-active'
            };

            //button html
            var buttonHtml = '' +
                '<button class="' + sn.button + ' ' + sn.buttonHidden + '">' +
                '<span class="show-mobile-menu-el"></span>' +
                '<span class="show-mobile-menu-el"></span>' +
                '<span class="show-mobile-menu-el"></span>' +
                '<span class="show-mobile-menu-el"></span>' +
                '</button>';

            //container html, where menu will be cloned
            var menuContainerHtml = '<ul class="' + sn.container + '"></ul>';

            //append button and container
            whereButtonAppendTo.append(buttonHtml);
            whereMenuAppendTo.append(menuContainerHtml);

            //take that button and container
            var button = $('.' + sn.button);
            var container = $('.' + sn.container);

            //clone menu to container
            container.html(whereMenuIs.children().clone());

            //open menu
            function open() {
                button.addClass(sn.buttonActive);
                container.addClass(sn.containerActive);
            }

            //close menu
            function close() {
                button.removeClass(sn.buttonActive);
                container.removeClass(sn.containerActive);
            }

            //show menu
            function show() {
                button.removeClass(sn.buttonHidden);
            }

            //hide all menu button and container
            function hide() {
                button
                    .addClass(sn.buttonHidden)
                    .removeClass(sn.buttonActive);
                container.removeClass(sn.containerActive);
            }

            //click handler
            function click() {
                if (button.hasClass(sn.buttonActive)) {
                    close();
                } else {
                    open();
                }
            }

            //public properties and methods
            this.button = '.' + sn.button;
            this.click = click;
            this.show = show;
            this.hide = hide;
            this.close = close;
        }

        //responsive
        function ResponsiveMenu(whereMenuIs, whereContainerAppendTo) {

            //selector names
            var sn = {
                wrapper: 'responsive-menu-wrapper',
                wrapperHidden: 'responsive-menu-wrapper-hidden',
                wrapperActive: 'responsive-menu-wrapper-active',
                button: 'show-responsive-menu',
                container: 'responsive-menu-container',
                containerActive: 'responsive-menu-container-active',
                menuItem: 'menu-item',
                menuItemHidden: 'menu-item-hidden'
            };

            //button html
            var buttonHtml = '' +
                '<li class="' + sn.wrapper + ' ' + sn.wrapperHidden + '">' +
                '<a href="#" class="' + sn.button + '">' + globalVars.translate["more"] + '<span class="genericon"></span></a>' +
                '</li>';

            //container html, where menu will be cloned
            var menuContainerHtml = '<ul class="' + sn.container + '"></ul>';

            //unique id to item
            var id_index = 1;

            // declare items
            var items = whereMenuIs
                .children('.' + sn.menuItem);

            //add unique id
            items
                .each(function () {
                    $(this).attr('data-rid', id_index);
                    id_index++;
                });

            //append items
            whereContainerAppendTo.append(menuContainerHtml);

            //declare container
            var container = $('.' + sn.container);

            //append items to container
            container.html(whereMenuIs.children().clone());

            //declare items which was appended
            var hiddenItems = container.children();

            hiddenItems.addClass(sn.menuItemHidden);

            //append button to menu
            whereMenuIs.append(buttonHtml);

            //declare button
            var wrapper = $('.' + sn.wrapper);

            //functions

            //open menu
            function openMenu() {
                if (!wrapper.hasClass(sn.wrapperActive)) {
                    wrapper.addClass(sn.wrapperActive);
                }
                if (!container.hasClass(sn.containerActive)) {
                    container.addClass(sn.containerActive);
                }
            }

            //close menu
            function closeMenu() {
                if (wrapper.hasClass(sn.wrapperActive)) {
                    wrapper.removeClass(sn.wrapperActive);
                }
                if (container.hasClass(sn.containerActive)) {
                    container.removeClass(sn.containerActive);
                }
            }

            //click handler
            function clickButton() {
                if (wrapper.hasClass(sn.wrapperActive)) {
                    closeMenu();
                } else {
                    openMenu();
                }
            }

            //show button
            function showButton() {
                if (wrapper.hasClass(sn.wrapperHidden)) {
                    wrapper.removeClass(sn.wrapperHidden);
                }
            }

            //hide menu button and container
            function hideAll() {
                closeMenu();
                if (!wrapper.hasClass(sn.wrapperHidden)) {
                    wrapper.addClass(sn.wrapperHidden);
                }
            }

            //make items default. Original visible, in container hidden
            function resetMenu() {
                hideAll();
                items.removeClass(sn.menuItemHidden);
                hiddenItems.addClass(sn.menuItemHidden);
            }

            //show the item
            function showItem(item) {
                if (!item.hasClass(sn.menuItemHidden)) {
                    return;
                }
                item.removeClass(sn.menuItemHidden);
            }

            //hide the item
            function hideItem(item) {
                if (item.hasClass(sn.menuItemHidden)) {
                    return;
                }
                item.addClass(sn.menuItemHidden);
            }

            //handle logic. Take number of items to show
            function handle(visibleItems) {

                items
                    .each(function (itemIndex) {
                        var item = $(this);
                        if (itemIndex < visibleItems) {
                            showItem(item);
                            hideItem(hiddenItems.filter('[data-rid=' + item.attr('data-rid') + ']'))
                        } else {
                            hideItem(item);
                            showItem(hiddenItems.filter('[data-rid=' + item.attr('data-rid') + ']'))
                        }
                    });

                //if all items can be showing in original menu, hide button and container
                if (visibleItems >= items.length) {
                    hideAll();
                } else {
                    showButton();
                }
            }

            //public properties and methods
            this.button = '.' + sn.button;
            this.wrapper = '.' + sn.wrapper;
            this.click = clickButton;
            this.close = closeMenu;
            this.reset = resetMenu;
            this.handle = handle;
        }

        //search
        function Search() {
            //selector names
            var sn = {
                'button': 'show-search',
                'buttonActive': 'show-search-active',
                'container': 'search-container',
                'containerActive': 'search-container-active'
            };

            //html button and container
            var button = $('.' + sn.button);
            var container = $('.' + sn.container);

            //open box
            function open() {
                button.addClass(sn.buttonActive);
                container.addClass(sn.containerActive);
            }

            //close box
            function close() {
                button.removeClass(sn.buttonActive);
                container.removeClass(sn.containerActive);
            }

            //click handler
            function click() {
                if (button.hasClass(sn.buttonActive)) {
                    close();
                } else {
                    open();
                }
            }

            //public properties and methods
            this.button = button;
            this.click = click;
            this.close = close;
        }

        //widgets
        function Widgets() {

            //selector names
            var sn = {
                'button': 'show-widgets',
                'buttonActive': 'show-widgets-active',
                'container': 'widgets-container',
                'containerActive': 'widgets-container-active'
            };

            //html button and container
            var button = $('.' + sn.button);
            var container = $('.' + sn.container);
            //open box
            function open() {
                button.addClass(sn.buttonActive);
                container.addClass(sn.containerActive);
            }

            //close box
            function close() {
                button.removeClass(sn.buttonActive);
                container.removeClass(sn.containerActive);
            }

            //click handler
            function click() {
                if (button.hasClass(sn.buttonActive)) {
                    close();
                } else {
                    open();
                }
            }

            //public properties and methods
            this.button = button;
            this.click = click;
            this.close = close;
        }

        //calculate data for choosing which menu should be showing
        function ResponsiveData(navMenu, items, exclude) {

            //array will contain menu items width
            var itemsWidth = [];

            //get item width
            items.each(function () {
                itemsWidth.push($(this).outerWidth(true));
            });

            //get exclude width. It means width of other element, which should be handled
            var excludeWidth = exclude.reduce(function (a, b) {
                return a + b;
            });


            //public method. Calculate how many items can be showed
            this.visibleItems = function () {

                var allowedWidth = navMenu.innerWidth() - excludeWidth;
                var visibleItemsWidth = 0;
                var visibleItemIndex = -1;

                $.each(itemsWidth, function (index, itemWidth) {

                    if (allowedWidth - (visibleItemsWidth + itemWidth) > 0) {
                        visibleItemsWidth += itemWidth;
                        visibleItemIndex = index;
                        return;
                    }
                    return false;

                });
                return visibleItemIndex + 1;
            };
        }

        //simple handle original menu
        var NavMenu = function () {
            //selector of hidden state
            var hiddenSelector = 'nav-menu-hidden';
            //get menu
            var menu = $('.nav-menu');

            //public properties and methods
            this.menu = menu;
            //show menu
            this.show = function () {
                if (menu.hasClass(hiddenSelector)) {
                    menu.removeClass(hiddenSelector);
                }
            };
            //hide menu
            this.hide = function () {
                if (!menu.hasClass(hiddenSelector)) {
                    menu.addClass(hiddenSelector);
                }
            }
        };

        //init elements
        var body = $('body');

        //where all primary buttons and menu have shown
        var sidebarNav = $('.sidebar-nav');
        //Where dynamic menus, like mobile etc. will be cloned
        var menuContainer = $('.menu-container');
        //control buttons, like search and widgets
        var sidebarControls = $('.sidebar-controls');
        //where widgets are. Needs for sub menu handler
        var widgetContent = $('.widgets-container-content');

        //call objects. The order is important
        //main menu
        var navMenu = new NavMenu();

        //sub menu
        var subMenu = new SubMenu();

        if (navMenu.menu.length) {
            //mobile menu
            var mobileMenu = new MobileMenu(navMenu.menu, sidebarNav, menuContainer);
            //responsive menu ('More' button)
            var responsiveMenu = new ResponsiveMenu(navMenu.menu, menuContainer);

            //add sub menu handler to all sub-menus
            subMenu.add(menuContainer, 'sub-menu');

            //call handler of original menus sub-menu
            var subMenuTop = new SubMenuTop(navMenu.menu, menuContainer, subMenu.add);

            //get all responsive data
            var responsiveData = new ResponsiveData(
                navMenu.menu,
                navMenu.menu.children('.menu-item'),
                [
                    $(responsiveMenu.wrapper).outerWidth(true),
                    //FIXME safari doesn't handle properly
                    sidebarControls.outerWidth(true)
                ],
                3
            );

            //handle which menu must be shown
            function handleMenu() {

                var visibleItems = responsiveData.visibleItems();

                if (visibleItems < 3) {
                    cleanSections();
                    mobileMenu.show();
                    navMenu.hide();
                    responsiveMenu.reset();

                } else {
                    mobileMenu.hide();
                    navMenu.show();
                    responsiveMenu.handle(visibleItems);
                }
            }

            handleMenu();

            //header sub menu button handler
            body.on('click', subMenuTop.wrapper + '>a', function (event) {
                event.preventDefault();
                cleanSections('subMenuTop');
                subMenuTop.click($(this));
            });

            //mobile menu button handler
            body.on('click', mobileMenu.button, function () {
                cleanSections('mobileMenu');
                mobileMenu.click();
            });

            //responsive menu button handler
            body.on('click', responsiveMenu.button, function (event) {
                event.preventDefault();
                cleanSections('responsiveMenu');
                responsiveMenu.click();
            });

            //handle window resize
            $(window).resize(function () {
                handleMenu();
            });
        }


        //search
        var search = new Search();
        //widgets
        var widgets = new Widgets();

        //Add sub menus for widgets
        subMenu.add(widgetContent, 'sub-menu');
        subMenu.add(widgetContent, 'children');


        //Before opening any menu, other menus must be closed
        //FIXME when switching mobile menu and original, search and widgets must be not closing
        function cleanSections(exclude) {
            subMenu.reset(menuContainer);

            if (exclude !== 'search') {
                search.close();
            }
            if (exclude !== 'widgets') {
                widgets.close();
            }

            if (!navMenu.menu.length) {
                return;
            }

            if (exclude !== 'subMenuTop') {
                subMenuTop.close();
            }
            if (exclude !== 'mobileMenu') {
                mobileMenu.close();
            }
            if (exclude !== 'responsiveMenu') {
                responsiveMenu.close();
            }
        }


        //sub menu button handler
        body.on('click', subMenu.button, function () {
            subMenu.click($(this));
        });


        //search button handler
        search.button.click(function () {
            cleanSections('search');
            search.click();
        });

        //widgets button handler
        widgets.button.click(function () {
            cleanSections('widgets');
            widgets.click();
        });


    })();

    //content
    (function () {

        //is link to file
        function isFilename(url) {

            return url != '' && url.split('.').length > 1;
        }

        //get link from href
        function getHrefPath(link) {
            var path = link.pathname.split('/');

            if (path.length === 1) {
                return false;
            }

            return path.pop();
        }

        //check, is link to image
        function isLinkToImage(link) {
            var hrefPath = getHrefPath(link[0]);

            return hrefPath && isFilename(hrefPath) && link.children('img').length;
        }

        //handle gallery items
        $('.gallery-item').each(function () {
            var $this = $(this),
                link = $this.find('a');

            if (!link.length || !isLinkToImage(link)) {
                return;
            }

            var caption = $this.find('.gallery-caption');

            if (caption.length) {
                link.attr('title', caption.text().trim());
            }

            link.addClass('gallery-link-image');

            if ($this.index() === 0) {
                $this.closest('.gallery').addClass('mfp-ready-gallery');
            }
        });

        //handle stand alone images
        $('.post-content').find('a').each(function () {
            var $this = $(this);

            if ($this.hasClass('gallery-link-image') || !isLinkToImage($this)) {
                return;
            }

            var caption = $this.siblings('.wp-caption-text');

            if (caption.length) {
                $this.attr('title', caption.text().trim());
            }

            $this.addClass('post-link-image');
        });

        //append button with link to image
        var openInNewWindowLink = function () {
            $('.mfp-counter').append('<a href="' + $.magnificPopup.instance.currItem.el.attr('href') + '" class="mfp-redirect" title="' + globalVars.translate["open-in-new-window"] + '" target="_blank"><span class="genericon genericon-external"></span></a>');
        };

        //turn on popup for gallery
        $('.mfp-ready-gallery').each(function () {
            $(this).find('a').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                },
                callbacks: {
                    open: openInNewWindowLink
                }
            });
        });

        //turn on popup for stand alone images
        $('.post-link-image').magnificPopup({
            type: 'image',
            callbacks: {
                open: openInNewWindowLink
            }
        });

        //handle showing hidden meta of post
        $('.post-meta__show-hidden').click(function () {
            var $this = $(this),
                wrapper = $this.closest('.post-meta'),
                show_block = wrapper.find('.post-meta__hidden');

            $this.toggleClass('post-meta__show-hidden-open');
            show_block.toggleClass('post-meta__hidden-show');
        });

        //format chat format post
        $('.format-chat .post-content')
            .find('p')
            .each(function () {
                var $this = $(this),
                    content = $this.text(),
                    delimiterIndex = content.indexOf(':');

                if (delimiterIndex === -1) {
                    return;
                }

                var member = content.slice(0, delimiterIndex + 1),
                    textBeginFrom = delimiterIndex + 1,
                    text = content.slice(textBeginFrom).trim();

                $this.html('<span class="chat-member">' + member + '</span><span class="chat-text">' + text + '</span>');
            });
    })();

    //hide contents when its height big enough
    (function () {

        //if it is singular page, return
        if($('body').hasClass('singular')){
            return;
        }

        //selector names
        var sn = {
                content: 'post-content',
                wrapper: 'post-content__wrapper',
                wrapperOpen: 'post-content__wrapper-open',
                show: 'post-content__show',
                showOpen: 'post-content__show-open',
                shadow: 'post-content__shadow'
            },
            initOffset = 0,
            defaultHeight = 500;

        //handle posts, where hide not big enough
        $('.' + sn.wrapper).each(function () {
            var $this = $(this);

            if ($this.children('.' + sn.content).height() > defaultHeight + 100) {
                $this
                    .addClass(sn.wrapperOpen)
                    .css({height: defaultHeight});
            }
        });

        //show hidden content
        $('.' + sn.show).click(function (event) {
            event.preventDefault();

            var $this = $(this),
                wrapper = $this.parent('.' + sn.wrapper),
                content = $this.siblings('.' + sn.content),
                shadow = $this.siblings('.' + sn.shadow);

            if (!wrapper.hasClass(sn.wrapperOpen)) {
                return;
            }

            if ($this.hasClass(sn.showOpen)) {
                wrapper.css({height: defaultHeight});
                shadow.show();

                $(window).scrollTop(initOffset);
            } else {
                initOffset = $(window).scrollTop();

                wrapper.css({height: content.height() + 25});
                shadow.hide();
            }

            $this.toggleClass(sn.showOpen);
        })

    })();

})(jQuery, whiteturtle_vars);
