/*! jQuery asTabs - v0.3.1 - 2014-12-17
* https://github.com/amazingSurge/jquery-asTabs
* Copyright (c) 2014 amazingSurge; Licensed GPL */
(function($, document, window, undefined) {
    "use strict";

    var pluginName = 'asTabs';
    // main constructor
    var Plugin = $[pluginName] = function(element, options) {

        var self = this;

        this.element = element;
        this.$element = $(element);
        this.options = $.extend(true, {}, Plugin.defaults, options, this.$element.data('options'));
        this.namespace = this.options.namespace;
        this.initialIndex = this.options.initialIndex;
        this.initialized = false;
        this.disabled = false;
        this.actived = false;
        this.current = null;

        // Class
        this.classes = {
            withJs: 'with-js',
            activeTab: 'is-active',
            activePane: 'is-active',
            nav: this.namespace + '-nav',
            content: this.namespace + '-content',
            disabled: this.namespace + '-disabled',
            skin: this.namespace + '_' + this.options.skin
        };

        if (this.options.navSelector) {
            this.$nav = this.$element.find(this.options.navSelector);
            this.$content = this.$element.find(this.options.contentSelector)
        } else {
            this.$nav = this.$element;
            if (this.options.contentSelector === '+') {
                this.$content = this.$nav.next();
            } else {
                this.$content = $(this.options.contentSelector);
            }
        }

        this.$nav.addClass(this.classes.nav).addClass(this.classes.withJs);
        this.$content.addClass(this.classes.content).addClass(this.classes.withJs);

        this.$tabs = this.$nav.children();
        this.$panes = this.$content.children();
        this.$loading = $('<span class="' + this.namespace + '-loading"></span>');

        this.size = this.$tabs.length;

        if (this.options.skin) {
            this.$element.addClass(this.classes.skin);
            this.$content.addClass(this.classes.skin);
        }

        if (this.options.ajax === true) {
            this.ajax = [];
            $.each(this.$tabs, function(i, v) {
                var obj = {};
                obj.href = $(v).data('href');
                self.ajax.push(obj);
            });
        }

        this.init();
    };

    // Default options for the plugin as a simple object
    Plugin.defaults = {
        namespace: 'asTabs',
        navSelector: null,
        contentSelector: '+',
        skin: null,
        initialIndex: 0,
        ajax: false,
        cached: false,
        history: false,
        historyAttr: 'id',
        keyboard: false,
        effect: false,
        duration: 300,
        event: 'click'
    };
    Plugin.prototype = {
        constructor: Plugin,
        init: function() {
            var self = this;

            // Bind logic
            this.$nav.on(this.options.event, '> *', function(e) {
                if (self.disabled) {
                    return false;
                }
                var index = $(this).index();
                self.active(index);
                return false;
            });

            this._trigger('init');

            this.active(this.initialIndex);
            this.actived = true;

            this.initialized = true;

            this._trigger('ready');
        },
        _trigger: function(eventType) {
            var method_arguments = Array.prototype.slice.call(arguments, 1),
                data = [this].concat(method_arguments);

            // event
            this.$element.trigger(pluginName + '::' + eventType, data);

            // callback
            eventType = eventType.replace(/\b\w+\b/g, function(word) {
                return word.substring(0, 1).toUpperCase() + word.substring(1);
            });
            var onFunction = 'on' + eventType;

            if (typeof this.options[onFunction] === 'function') {
                this.options[onFunction].apply(this, method_arguments);
            }
        },
        active: function(index, update) {
            if (this.current >= 0) {
                if (this.current === index || index >= this.size || index < 0) {
                    return;
                }
            } else {
                if (index >= this.size) {
                    index = this.size - 1;
                } else if (index < 0) {
                    index = 0;
                }
            }

            this.$tabs.eq(index).addClass(this.classes.activeTab).siblings().removeClass(this.classes.activeTab);

            var self = this;

            if (this.current === null) {
                this.$panes.eq(index).addClass(this.classes.activePane).siblings().removeClass(this.classes.activePane);
            } else {
                self._trigger('animation', self.current, index);

                if (!self.effects) {
                    self.$panes.eq(self.current).fadeOut(self.options.duration, function() {
                        $(this).removeClass('is-active');

                        self.$panes.eq(index).fadeIn(self.options.duration, function() {
                            $(this).addClass('is-active');
                        });
                    });
                }
            }

            self.previous = self.current;
            self.current = index;

            if (self.options.ajax === true) {
                self.ajaxLoad(index);
            }

            self._trigger('active', index);

            if (update !== false) {
                self._trigger('update', index);
            }
        },
        ajaxLoad: function(index) {
            var self = this,
                dtd;
            if (this.options.cached === true && this.ajax[index].cached === true) {
                return;
            } else {
                this.showLoading();
                dtd = $.ajax({
                    url: this.ajax[index].href
                });
                dtd.done(function(data) {
                    self.ajax[index].cached = true;
                    self.hideLoading();
                    self.$panes.eq(index).html(data);
                });
                dtd.fail(function() {
                    self.hideLoading();
                    self.$panes.eq(index).html('failed');
                });
                dtd.always(function() {
                    self._trigger('loaded', index);
                });
            }
        },
        showLoading: function() {
            this.$loading.appendTo(this.$content);
        },
        hideLoading: function() {
            this.$loading.remove();
        },
        getTabs: function() {
            return this.$tabs;
        },
        getPanes: function() {
            return this.$panes;
        },
        getCurrentPane: function() {
            return this.$panes.eq(this.current);
        },
        getCurrentTab: function() {
            return this.$tabs.eq(this.current);
        },
        getIndex: function() {
            return this.current;
        },
        getSize: function() {
            return this.size;
        },
        append: function(title, content) {
            return this.add(title, content, this.size);
        },
        add: function(title, content, index) {
            if (index > this.size + 1) {
                index = this.size + 1;
            } else if (index < 0) {
                index = 0;
            }

            if (index === 0) {
                this.$nav.append($('<li/>', {
                    class: this.classes.activeTab
                }).html(title));
                this.$content.append($('<div/>', {
                    class: this.classes.activePane
                }).html(content));
                this.current = 0;
            } else {
                this.$tabs.eq(index - 1).after(this.$tabs.eq(0).clone().removeClass(this.classes.activeTab).html(title));
                this.$panes.eq(index - 1).after(this.$panes.eq(0).clone().removeClass(this.classes.activePane).html(content));
            }

            this.$tabs = this.$nav.children();
            this.$panes = this.$content.children();
            this.size++;

            return this;
        },
        remove: function(index) {
            if (index > this.size || index < 0 || this.size === 0) {
                return this;
            }
            this.$tabs.eq(index).remove();
            this.$panes.eq(index).remove();

            this.$tabs = this.$nav.children();
            this.$panes = this.$content.children();
            this.size--;

            if (this.current === index) {
                if (index > this.size) {
                    index = 0;
                }
                this.active(index);
            }
            return this;
        },
        next: function() {
            var current = this.current;
            if (current < this.size - 1) {
                current++;
            } else {
                current = 0;
            }

            this.active(current);

            return this;
        },
        prev: function() {
            var current = this.current;
            if (current === 0) {
                current = Math.abs(1 - this.size);
            } else {
                current = current - 1;
            }

            this.active(current);

            return this;
        },
        revert: function(update) {
            var index = 0;
            if (this.options.initialIndex) {
                index = this.options.initialIndex;
            }

            this.active(index, update);

            return this;
        },
        enable: function() {
            if (this.disabled === true) {
                this.disabled = false;
                this.$nav.removeClass(this.classes.disabled);
                this.$content.removeClass(this.classes.disabled);
            }
            return this;
        },
        disable: function() {
            if (this.disabled === false) {
                this.disabled = true;
                this.$nav.addClass(this.classes.disabled);
                this.$content.addClass(this.classes.disabled);
            }
            return this;
        },
        destroy: function() {
            this.$nav.removeClass(this.classes.nav).removeClass(this.classes.withJs);
            this.$content.removeClass(this.classes.content).removeClass(this.classes.withJs);

            this.$tabs.removeClass(this.classes.activeTab);
            this.$panes.removeClass(this.classes.activePane);
            this.$nav.off(this.options.event);
            $.data(this.$element, pluginName, null);
        }
    };
    // Collection method.
    $.fn[pluginName] = function(options) {
        if (typeof options === 'string') {
            var method = options;
            var method_arguments = Array.prototype.slice.call(arguments, 1);

            if (/^\_/.test(method)) {
                return false;
            } else if (/^(getTabs|getPanes|getCurrentPane|getCurrentTab|getIndex|getSize)$/.test(method)) {
                var api = this.first().data(pluginName);
                if (api && typeof api[method] === 'function') {
                    return api[method].apply(api, method_arguments);
                }
            } else {
                return this.each(function() {
                    var api = $.data(this, pluginName);
                    if (api && typeof api[method] === 'function') {
                        api[method].apply(api, method_arguments);
                    }
                });
            }
        } else {
            return this.each(function() {
                if (!$.data(this, pluginName)) {
                    $.data(this, pluginName, new Plugin(this, options));
                }
            });
        }
    };
})(jQuery, document, window);

// jquery asTabs history
(function(window, document, $, undefined) {
    "use strict";

    if (!window.history || !window.history.pushState || !window.history.replaceState) {
        return;
    }

    var $doc = $(document);
    var id_count = 1;

    $doc.on('asTabs::init', function(event, instance) {
        if (instance.options.history === false) {
            return;
        }
        if (instance.options.history !== true) {
            instance.historyId = instance.options.history;
        } else {
            var id = instance.$element.attr('id');

            if (id) {
                instance.historyId = id;
            } else {
                instance.historyId = 'tabs_' + id_count;
                id_count++;
            }
        }

        // active the matched tab
        var match = new RegExp('[#&]*' + instance.historyId + '=([^&]*)', 'i')
            .exec(window.location.hash);

        if (match) {
            var slug = decodeURIComponent(match[1].replace(/\+/g, ' '));
            var $tab = instance.$nav.find('[' + instance.options.historyAttr + '="' + slug + '"]');

            if ($tab.length >= 1) {
                instance.initialIndex = instance.$tabs.index($tab);
            } else if (!isNaN(parseFloat(slug)) && isFinite(slug)) {
                instance.initialIndex = slug;
            }
        }

        $(window).on('popstate', function(event) {
            var state = event.originalEvent.state;
            if (state && typeof state[instance.historyId] !== 'undefined') {
                if (state[instance.historyId].index) {
                    instance.active(state[instance.historyId].index, false);
                }
                event.preventDefault();
            } else {
                instance.revert(false);
            }
        });
    });

    $doc.on('asTabs::update', function(event, instance) {
        if (instance.options.history === false || typeof instance.historyId === 'undefined') {
            return;
        }
        if (instance.actived === false) {
            return;
        }
        var index = instance.current,
            state = {
                index: index
            },
            content = instance.$tabs.eq(index).attr(instance.options.historyAttr);

        if (content) {
            state.slug = content;
        } else {
            state.slug = index;
        }
        if (index === instance.options.initialIndex) {
            state.initial = true;
        }

        var url = window.location.hash;

        if (url === '') {
            url = '#';
        }

        var reg = new RegExp('&*' + instance.historyId + '=[^&]+', "i");
        if (state.initial) {
            url = url.replace(reg, '');
        } else {
            if (url.match(reg)) {
                url = url.replace(reg, '&' + instance.historyId + '=' + state.slug);
            } else {
                url = url + '&' + instance.historyId + '=' + state.slug;
            }
        }
        var states = history.state;
        if (!states) {
            states = {};
        }
        states[instance.historyId] = state;

        url = url.replace(/^#&/, '#');
        window.history.pushState(states, "", url);
    });
})(window, document, jQuery);

// jquery asTabs keyboard
(function(window, document, $, undefined) {
    "use strict";

    var $doc = $(document);
    var keyboard = {
        keys: {
            'UP': 38,
            'DOWN': 40,
            'LEFT': 37,
            'RIGHT': 39,
            'RETURN': 13,
            'ESCAPE': 27,
            'BACKSPACE': 8,
            'SPACE': 32
        },
        map: {},
        bound: false,
        press: function(e) {
            var key = e.keyCode || e.which;
            if (key in keyboard.map && typeof keyboard.map[key] === 'function') {
                e.preventDefault();
                return keyboard.map[key].call(this, e);
            }
        },
        attach: function(map) {
            var key, up;
            for (key in map) {
                if (map.hasOwnProperty(key)) {
                    up = key.toUpperCase();
                    if (up in keyboard.keys) {
                        keyboard.map[keyboard.keys[up]] = map[key];
                    } else {
                        keyboard.map[up] = map[key];
                    }
                }
            }
            if (!keyboard.bound) {
                keyboard.bound = true;
                $doc.bind('keydown', keyboard.press);
            }
        },
        detach: function() {
            keyboard.bound = false;
            keyboard.map = {};
            $doc.unbind('keydown', keyboard.press);
        }
    };

    $doc.on('asTabs::init', function(event, instance) {
        if (instance.options.keyboard === false) {
            return;
        }

        // make ul div etc. get focus
        instance.$element.add(instance.$panes_wrap).attr('tabindex', '0').on('focus', function() {
            keyboard.attach({
                left: $.proxy(instance.prev, instance),
                right: $.proxy(instance.next, instance)
            });
            return false;
        }).on('blur', function() {
            keyboard.detach();
            return false;
        });

        instance.$panes.attr('tabindex', '0').on('focus', function(e) {
            keyboard.attach({
                left: $.proxy(instance.prev, instance),
                right: $.proxy(instance.next, instance)
            });
            e.preventDefault();
            return false;
        }).on('blur', function(e) {
            keyboard.detach();
            e.preventDefault();
            return false;
        });
    });
})(window, document, jQuery);

// elementTransitions
(function(window, document, $, undefined) {
    "use strict";

    var $doc = $(document);

    var revertClass = function(str) {
        var classes = str.split(" "),
            len = classes.length,
            inre = ['Up', 'Down', 'In', 'Out', 'Left', 'Right', 'Top', 'Bottom'],
            outre = ['Down', 'Up', 'Out', 'In', 'Right', 'Left', 'Bottom', 'Top'],
            output = "",
            re = "",
            re_array = [],
            re_num = "";

        for (var n = 0; n < len; n++) {
            for (var m = 0; m < inre.length; m++) {
                re = new RegExp(inre[m]);
                if (re.test(classes[n])) {
                    re_array.push(m);
                }
            }
            for (var l = 0; l < re_array.length; l++) {
                re_num = re_array[l];
                classes[n] = classes[n].replace(inre[re_num], re_num);
            }
            for (var k = 0; k < re_array.length; k++) {
                re_num = re_array[k];
                classes[n] = classes[n].replace(re_num, outre[re_num]);
            }
            output += " " + classes[n];
        }
        return $.trim(output);
    };

    var animationend = (function() {
        var t;
        var el = document.createElement('fakeelement');
        var animations = {
            'animation': 'animationend',
            '-o-animation': 'oAnimationEnd',
            '-moz-animation': 'animationend',
            '-webkit-animation': 'webkitAnimationEnd'
        };

        for (t in animations) {
            if (el.style[t] !== undefined) {
                return animations[t];
            }
        }

        return false;
    })();

    if (animationend === false) return;

    $doc.on('asTabs::init', function(event, instance) {
        if (instance.options.effect === false) {
            return false;
        }

        instance.effects = {
            inClass: instance.options.effect,
            outClass: revertClass(instance.options.effect)
        };

        instance.$content.children().css({
            '-webkit-animation-duration': instance.options.duration + 'ms',
            'animation-duration': instance.options.duration + 'ms'
        })
        instance.$content.addClass('with-effects');
    });

    $doc.on('asTabs::ready', function(event, instance) {
        if (instance.options.effect === false) {
            return false;
        }
        $(window).bind('resize orientationchange', function() {
            clearTimeout(instance.resizingTimeout);
            instance.resizingTimeout = setTimeout(function() {
                var height = instance.getCurrentPane().outerHeight(true);

                instance.$content.height(height);
            }, 500);
        });
    });

    $doc.on('asTabs::active asTabs::loaded', function(event, instance) {
        if (instance.options.effect === false) {
            return false;
        }

        var height = instance.getCurrentPane().outerHeight(true);
        instance.$content.height(height);
    });

    $doc.on('asTabs::animation', function(event, instance, from, to) {
        if (instance.options.effect === false || instance.initialized === false) {
            return false;
        }

        var $to = instance.$panes.eq(to),
            $from = instance.$panes.eq(from);

        instance.isAnimating = true;

        $from.removeClass(instance.effects.inClass).addClass(instance.effects.outClass + ' animated').one(animationend, function() {
            $from.removeClass(instance.effects.outClass + ' animated').removeClass('is-active');

            $to.removeClass(instance.effects.outClass).addClass('is-active').addClass(instance.effects.inClass + ' animated').one(animationend, function() {
                $to.removeClass(instance.effects.inClass);

                instance.isAnimating = false;
            });
        });
    });
})(window, document, jQuery);
