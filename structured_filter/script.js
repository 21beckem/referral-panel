! function(d) {
    var h = "boolean",
        p = "number",
        c = "date",
        v = "time",
        f = "list",
        b = "list-options",
        _ = "list-dropdown",
        m = {
            sEqual: "equals",
            sNotEqual: "not equal",
            sStart: "starts with",
            sContain: "contains",
            sNotContain: "doesn't contain",
            sFinish: "finishes with",
            sInList: "any of",
            sIsNull: "is empty",
            sIsNotNull: "is not empty",
            sBefore: "before",
            sAfter: "after",
            sNumEqual: "&#61;",
            sNumNotEqual: "!&#61;",
            sGreater: "&#62;",
            sSmaller: "&#60;",
            sOn: "on",
            sNotOn: "not on",
            sAt: "at",
            sNotAt: "not at",
            sBetween: "between",
            sNotBetween: "not between",
            opAnd: "and",
            yes: "Yes",
            no: "No",
            bNewCond: "New filter condition",
            bAddCond: "Add condition",
            bUpdateCond: "Update condition",
            bSubmit: "Submit",
            bCancel: "Cancel"
        },
        u = "eq",
        s = "ne",
        a = "sw",
        l = "ct",
        o = "nct",
        r = "fw",
        g = "in",
        y = "null",
        k = "nn",
        w = "gt",
        N = "lt",
        C = "bw",
        F = "nbw",
        t = -1 === navigator.userAgent.toLowerCase().indexOf("firefox");
    d.widget("evol.structFilter", {
        options: {
            fields: [],
            dateFormat: "mm/dd/yy",
            highlight: !0,
            buttonLabels: !1,
            submitButton: !1,
            submitReady: !1,
            disableOperators: !1
        },
        _create: function() {
            function t(t, e, i) {
                return '<a class="' + t + '"' + (i ? ' style="display:none;"' : "") + ' href="javascript:void(0)">' + e + '</a>'
            }
            var e = this.options.buttonLabels,
                s = this,
                i = this.element,
                n = '<div class="evo-searchFilters"></div>' + t("evo-bNew", m.bNewCond);
            this.options.submitButton && (n += t("evo-bSubmit", m.bSubmit)), n += '<div class="evo-editFilter"></div>' + t("evo-bAdd", m.bAddCond, !0) + t("evo-bDel", m.bCancel, !0), this._step = 0, i.addClass("structFilter ui-widget-content ui-corner-all").html(n), this.options.submitReady && (this._hValues = d("<span></span>").appendTo(i)), this.options.submitButton && (this._bSubmit = i.find(".evo-bSubmit").button({
                showLabel: e
            }).on("click", function(t) {
                s.element.trigger("submit.search")
            })), this._bNew = i.find(".evo-bNew").button({
                showLabel: e,
                icon: "ui-icon-plusthick",
                iconPosition: "end"
            }).on("click", function(t) {
                s._step < 1 && (s._setEditorField(), s._step = 1), s._bAdd.find(".ui-button-text").html(m.bAddCond)
            }), this._bAdd = i.find(".evo-bAdd").button({
                showLabel: e,
                icon: "ui-icon-check",
                iconPosition: "end"
            }).on("click", function(t) {
                var e = s._getEditorData();
                s._cFilter ? s._enableFilter(e, s.options.highlight) : s.addCondition(e), s._removeEditor()
            }), this._bDel = i.find(".evo-bDel").button({
                showLabel: e,
                icon: "ui-icon-close",
                iconPosition: "end"
            }).on("click", function(t) {
                s._removeEditor()
            }), this._editor = i.find(".evo-editFilter").on("change", "#field", function(t) {
                t.stopPropagation(), 2 < s._step && s._editor.find("#value,#value2,.as-Txt").remove(), 1 < s._step && (s._editor.find("#operator").remove(), s._bAdd.hide()), s._step = 1;
                t = d(t.currentTarget).val();
                "" !== t ? (s._field = s._getFieldById(t), t = s._type = s._field.type, s._setEditorOperator(), t !== h && !t.startsWith("list") || s._setEditorValue()) : s._field = s._type = null
            }).on("change", "#operator", function(t) {
                t.stopPropagation(), s._operator = d(this).val(), 2 < s._step && (s._editor.find("#value,#value2,.as-Txt").remove(), s._bAdd.hide(), s._step = 2), s._setEditorValue()
            }).on("change keyup", "#value,#value2", function(t) {
                t.stopPropagation();
                var e = s._type,
                    i = d(this).val(),
                    n = "" !== i || e === h || e.startsWith("list");
                e == p ? n = n && !isNaN(i) : s._operator != C && s._operator != F || (n = "" !== s._editor.find("#value").val() && "" !== s._editor.find("#value2").val()), n ? (s._bAdd.button("enable"), 13 == t.which && s._bAdd.trigger("click")) : s._bAdd.button("disable")
            }).on("click", "#checkAll", function() {
                var t = d(this),
                    e = t.prop("checked");
                allChecks = t.parent().parent().find("input").prop("checked", e)
            }), this._filters = i.find(".evo-searchFilters").on("click", "a", function() {
                s._editFilter(d(this))
            }).on("click", "a .ui-button-icon", function(t) {
                t.stopPropagation();
                var e = d(this).parent();
                e.hasClass("ui-state-disabled") || e.fadeOut("slow", function() {
                    e.remove(), s._triggerChange()
                })
            })
        },
        _getFieldById: function(t) {
            if (!this._hash) {
                this._hash = {};
                for (var e = this.options.fields, i = 0, n = e.length; i < n; i++) this._hash[e[i].id] = e[i]
            }
            return this._hash[t]
        },
        _removeEditor: function() {
            this._editor.empty(), this._bAdd.hide(), this._bDel.hide(), this._enableFilter(null, !1), this._bNew.removeClass("ui-state-active").show(), this._bSubmit && this._bSubmit.removeClass("ui-state-active").show(), t && this._bNew.focus(), this._step = 0, this._field = this._type = this._operator = null
        },
        addCondition: function(t) {
            t = d('<a href="javascript:void(0)"><span>' + this._htmlFilter(t) + "</span>"+'<span class="ui-button-icon-space"> </span><span class="ui-button-icon ui-icon ui-icon-close"></span>'+"</a>").prependTo(this._filters).button({
                icon: "ui-icon-close",
                iconPosition: "end"
            }).data("filter", t).fadeIn();
            return this.options.highlight && t.effect("highlight"), this._triggerChange(), this._bSubmit && this._bSubmit.removeClass("ui-state-active").show(), this
        },
        removeCondition: function(t) {
            return this._removeEditor(), this._filters.children().eq(t).remove(), this._triggerChange(), this
        },
        _htmlFilter: function(t) {
            var e = '<span class="evo-lBold">' + t.field.label + '</span> <span class="evo-lLight">' + t.operator.label + '</span> <span class="evo-lBold">' + t.value.label + "</span>";
            return t.operator.value != C && t.operator.value != F || (e += '<span class="evo-lLight"> ' + m.opAnd + ' </span><span class="evo-lBold">' + t.value.label2 + "</span>"), e
        },
        _enableFilter: function(t, e) {
            this._cFilter && (this._cFilter.button("enable").removeClass("ui-state-hover ui-state-active"), e && this._cFilter.effect("highlight"), t ? (this._cFilter.data("filter", t).find(":first-child").html(this._htmlFilter(t)), this._cFilter = null, this._triggerChange()) : this._cFilter = null)
        },
        _editFilter: function(t) {
            var e = t.data("filter"),
                i = e.field.value,
                n = e.operator.value,
                e = e.value;
            this._enableFilter(null, !1), this._removeEditor(), this._cFilter = t.button("disable"), this._setEditorField(i), this._setEditorOperator(n), n == C || n == F ? this._setEditorValue(e.value, e.value2) : this._setEditorValue(e.value), this._bAdd.find(".ui-button-text").html(m.bUpdateCond), this._step = 3
        },
        _setEditorField: function(t) {
            this._step < 1 && (this._bNew.stop().hide(), this._bSubmit && this._bSubmit.stop().hide(), this._bDel.show(), this._fList || (this._fList = '<select id="field">' + A.optNull + this.options.fields.map(function(t) {
                return A.inputOption(t.id, t.label)
            }) + "</select>"), d(this._fList).appendTo(this._editor).focus()), t && (this._field = this._getFieldById(t), this._type = this._field.type, this._editor.find("#field").val(t)), this._step = 1
        },
        _setEditorOperator: function(t) {
            if (this.options.disableOperators) return this._step = 2, this._setEditorValue();
            var e = this._type;
            if (this._step < 2) {
                var i = "",
                    n = A.inputOption;
                switch (e) {
                    case f:
                        i += A.inputHidden("operator", g), this._operator = g;
                        break;
                    case b:
                    case _:
                    case h:
                        i += A.inputHidden("operator", u), this._operator = u;
                        break;
                    default:
                        switch (i += '<select id="operator">' + A.optNull, e) {
                            case c:
                            case v:
                                i += e == v ? n(u, m.sAt) + n(s, m.sNotAt) : n(u, m.sOn) + n(s, m.sNotOn), i += n(w, m.sAfter) + n(N, m.sBefore) + n(C, m.sBetween) + n(F, m.sNotBetween);
                                break;
                            case p:
                                i += n(u, m.sNumEqual) + n(s, m.sNumNotEqual) + n(w, m.sGreater) + n(N, m.sSmaller);
                                break;
                            default:
                                i += n(u, m.sEqual) + n(s, m.sNotEqual) + n(a, m.sStart) + n(l, m.sContain) + n(o, m.sNotContain) + n(r, m.sFinish)
                        }
                        i += n(y, m.sIsNull) + n(k, m.sIsNotNull) + "</select>"
                }
                this._editor.append(i)
            }
            t && e != f && (this._editor.find("#operator").val(t), this._operator = t), this._step = 2
        },
        _setEditorValue: function(e, t) {
            var i = this._editor,
                n = this._field,
                s = this._type,
                a = i.find("#operator").val(),
                l = !1,
                o = !0;
            if ("" !== a) {
                if (s == f || a != y && a != k) {
                    if (this._step < 3) {
                        var r = "",
                            l = a == C || a == F;
                        switch (s) {
                            case h:
                                r += '<span id="value">' + A.inputRadio("value", "1", m.yes, "0" != e, "value1") + A.inputRadio("value", "0", m.no, "0" == e, "value0") + "</span>";
                                break;
                            case f:
                                r += '<span id="value">', 7 < n.list.length && (r += '<label for="checkAll">(<input type="checkbox" id="checkAll" value="1">All )</label> '), r += A.inputCheckboxes(n.list) + "</span>";
                                break;
                            case b:
                                r += '<span id="value">' + n.list.map(function(t) {
                                    return A.inputRadio(n.id, t.id, t.label, e == t.id, "value" + t.id)
                                }).join("") + "</span>";
                                break;
                            case _:
                                r += '<select id="value">' + A.optNull + n.list.map(function(t) {
                                    return A.inputOption(t.id, t.label)
                                }).join("") + "</select>";
                                break;
                            case c:
                            case v:
                            case p:
                                var d = s == c ? "text" : s;
                                r += '<input id="value" type="' + d + '">', l && (r += '<span class="as-Txt">' + m.opAnd + ' </span><input id="value2" type="' + d + '">'), o = !1;
                                break;
                            default:
                                r += '<input id="value" type="text">', o = !1
                        }
                        i.append(r), s == c && i.find("#value,#value2").datepicker({
                            dateFormat: this.options.dateFormat
                        })
                    }
                    if (e) {
                        var u = i.find("#value");
                        switch (s) {
                            case f:
                                u.find("#" + e.split(",").join(",#")).prop("checked", "checked");
                                break;
                            case b:
                            case h:
                                u.find("#value" + e).prop("checked", "checked");
                                break;
                            default:
                                u.val(e), o = "" !== e, l && (u.next().next().val(t), o = "" !== e && "" !== t)
                        }
                    } else o = s == f || s == _ || s == h
                } else i.append(A.inputHidden("value", ""));
                this._bAdd.button(o ? "enable" : "disable").show(), this._step = 3
            }
        },
        _getEditorData: function() {
            var t, e, i, n, s = this._editor,
                a = s.find("#field"),
                l = s.find("#value"),
                o = {
                    field: {
                        label: a.find("option:selected").text(),
                        value: a.val()
                    },
                    operator: {},
                    value: {}
                },
                r = o.operator,
                a = o.value;
            return this._type == f ? (t = [], e = [], l.find("input:checked").not("#checkAll").each(function() {
                t.push(this.value), e.push(d(this).parent().text())
            }), 0 === t.length ? (r.label = m.sIsNull, r.value = y, a.label = a.value = "") : 1 == t.length ? (r.label = m.sEqual, r.value = u, a.label = '"' + e[0] + '"', a.value = t[0]) : (r.label = m.sInList, r.value = g, a.label = "(" + e.join(", ") + ")", a.value = t.join(","))) : this._type == h ? (r.label = m.sEqual, r.value = u, i = l.find("#value1").prop("checked") ? 1 : 0, a.label = 1 == i ? m.yes : m.no, a.value = i) : this._type == b ? (r.label = m.sEqual, r.value = u, i = l.find("input:checked"), a.label = i.parent().text(), a.value = i.prop("id").slice(5)) : this._type == _ ? (r.label = m.sEqual, r.value = u, n = l.val(), a.label = n ? l.find("option[value=" + n + "]").text() : m.sIsNull, a.value = l.val()) : (s = (n = s.find("#operator")).val(), r.label = n.find("option:selected").text(), (r.value = s) == y || s == k ? a.label = a.value = "" : (this._type == p || this._type == c || this._type == v ? a.label = l.val() : a.label = '"' + l.val() + '"', a.value = l.val(), s != C && s != F || (a.label2 = a.value2 = l.next().next().val()))), o
        },
        _hiddenValue: function(t, e, i) {
            t.push(A.inputHidden("fld-" + i, e.field.value) + A.inputHidden("op-" + i, e.operator.value) + A.inputHidden("val-" + i, e.value.value));
            e = e.value.value2;
            e && t.push(A.inputHidden("val2-" + i, e))
        },
        _setHiddenValues: function() {
            for (var t = this.val(), e = t.length, i = [A.inputHidden("elem", e)], n = 0; n < e; n++) this._hiddenValue(i, t[n], n + 1);
            this._hValues.html(i.join(""))
        },
        _triggerChange: function() {
            this.options.submitReady && this._setHiddenValues(), this.element.trigger("change.search")
        },
        val: function(t) {
            if (void 0 === t) {
                var e = [];
                return this._filters.find("a").each(function() {
                    e.push(d(this).data("filter"))
                }), e
            }
            this._filters.empty();
            for (var i = 0, n = t.length; i < n; i++) this.addCondition(t[i]);
            return this._triggerChange(), this
        },
        valText: function() {
            var t = [];
            return this._filters.find("a").each(function() {
                t.push(this.text.trim())
            }), t.join(" " + m.opAnd + " ")
        },
        valUrl: function() {
            var t = this.val(),
                e = t.length,
                i = "filters=" + e;
            return e < 1 ? "" : (t.forEach(function(t, e) {
                i += "&field-" + e + "=" + t.field.value + "&operator-" + e + "=" + t.operator.value + "&value-" + e + "=" + encodeURIComponent(t.value.value), t.operator.value != C && t.operator.value != F || (i += "&value2-" + e + "=" + encodeURIComponent(t.value.value2))
            }), i += "&label=" + encodeURIComponent(this.valText()))
        },
        clear: function() {
            return this._cFilter = null, this._removeEditor(), this._filters.empty(), this._triggerChange(), this
        },
        length: function() {
            return this._filters.children().length
        },
        destroy: function() {
            var t = this.element.off();
            t.find(".evo-bNew,.evo-bAdd,.evo-bDel,.evo-searchFilters").off(), this._editor.off(), this.clear(), t.empty().removeClass("structFilter ui-widget-content ui-corner-all"), d.Widget.prototype.destroy.call(this)
        }
    }), d.widget("evol.seti18n", {
        options: {},
        _create: function() {
            m = this.options
        }
    });
    var A = {
        inputRadio: function(t, e, i, n, s) {
            return '<label for="' + s + '"><input id="' + s + '" name="' + t + '" type="radio" value="' + e + (n ? '" checked="checked' : "") + '">' + i + "</label>&nbsp;"
        },
        inputHidden: function(t, e) {
            return '<input type="hidden" name="' + t + '" value="' + e + '">'
        },
        inputOption: function(t, e) {
            return '<option value="' + t + '">' + e + "</option>"
        },
        optNull: '<option value=""></option>',
        inputCheckboxes: function(t) {
            return t.map(function(t) {
                return '<label for="' + t.id + '"><input type="checkbox" id="' + t.id + '" value="' + t.id + '">' + t.label + "</label> "
            }).join("")
        }
    }
}(jQuery);