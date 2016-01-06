var emailSignupButton = {
    width: "677",
    height: "483"
};
var quickViewButton = {
    width: "803",
    height: "auto"
};
var expressCheckoutButton = {
    width: "555",
    height: "auto"
};
var expressCheckoutLink = {
    width: "555",
    height: "auto"
};
var sendToFriendButton = {
    width: "676",
    height: "auto"
};
var sendToFriendLink = {
    width: "676",
    height: "auto"
};
var areYouTaxExemptBtn = {
    width: "555",
    height: "auto"
};
var shippingFAQBtn = {
    width: "555",
    height: "auto"
};
var returnPolicyLink = {
    width: "676",
    height: "auto"
};
var warrantyInfoLink = {
    width: "676",
    height: "auto"
};
var taxExemptLink = {
    width: "676",
    height: "auto"
};
var loadParentIframe = 0;
var sessionexpurl = contextRoot + "/account/create_account.jsp?error=409";
var internalServerError = contextRoot + "/common/serverError.jsp";
$(window).resize(function() {
    dropDownOffset();
});
$(document).on("click", "#closeS7",
function(b) {
    b.preventDefault();
    window.parent.$("#PDPZOOM-View").dialog("close");
});
$("#closeS7").bind("touchstart",
function(b) {
    b.preventDefault();
    window.parent.$("#PDPZOOM-View").dialog("close");
});
$(document).on("hover", ".unFav",
function() {
    $(this).removeClass("unFav");
});
var mousebagFirsttime = "yes";
$(window).load(function() {
    if ($("#heroContainer").find(".flexslider").length > 0) {
        $("#heroContainer").find(".flexslider").flexslider({
            animation: "slide"
        });
        $(".flex-control-nav li").find("a").text("");
    }
});
$(".facetRefinement").click(function() {
    var c = $("#refinementName").val();
    var b = $("#filterName").val();
    _gaq.push(["_trackEvent", "Search", "Refinement", c]);
});
$(window).scroll(function() {
    if ($(this).scrollTop() > 117) {
        $("#header_mini_logo").fadeIn();
        $("#header_mini_logo").css("display", "block");
        $("#headerBar #headerBarRightContent").addClass("header_mini_logo_align");
    } else {
        $("#header_mini_logo").fadeOut();
        $("#header_mini_logo").css("display", "none");
        $("#headerBar #headerBarRightContent").removeClass("header_mini_logo_align");
    }
});
$(".swatch-outline a").bind("touchstart",
function() {
    location.href = $(this).attr("href");
});
$("form#contactCreationForm").find("textarea").on("keydown",
function(c) {
    if (c.which === 13) {
        var b = document.getElementById("comments");
        b.value += "\n";
        return false;
    }
});
function inputKeyDown(c, d) {
    if (c.keyCode == 13) {
        var b = document.getElementById("message");
        b.value += "\n";
        return false;
    }
}
$("form#resetPasswordEmailForm").find("#password").on("keydown",
function() {
    var b = $("form#resetPasswordEmailForm").find("#password").val();
    if (b != "") {
        $("form#resetPasswordEmailForm").find("#resetEmailSubmit").removeAttr("disabled");
    }
});
$("#mailingListSignUpForm").find("#mailingListSignUplogin").on("keydown",
function(b) {
    if (b.which === 13) {
        $("form#mailingListSignUpForm").submit();
    }
});
$("#storeFinderForm").find("#storeLocatorAddressField").on("keydown",
function(b) {
    if (b.which === 13) {
        $("form#storeFinderForm").submit();
    }
});
$(document).on("click", "#crossSells",
function(b) {
    s_crossSell();
});
function SetTabIndexToAddressPage() {
    var c = 31;
    if ($("#breadcrumb").length === 1) {
        $("#breadcrumb a").each(function() {
            $(this).attr("tabindex", c);
            c++;
        });
    }
    if ($("#profileLeftColumn").length === 1) {
        $("#profileLeftColumn a").each(function() {
            $(this).attr("tabindex", "32");
        });
    }
    if ($("#savedInformationColumn").length === 1) {
        $("#savedInformationColumn a").each(function() {
            $(this).attr("tabindex", c);
            c++;
        });
    }
    if ($("#profileDetailsContainer").length === 1 && $("#savedInformationColumn").length === 0) {
        $("#liEditProfileAction").attr("tabindex", c);
        c++;
        $("#changePasswordAction").attr("tabindex", c);
        c++;
        $("#faceBookSignin").attr("tabindex", c);
        c++;
        $("#twitterSignin").attr("tabindex", c);
        c++;
        if ($("#addAllToBagForm").length === 0) {
            $("#profileDetailsContainer a").each(function() {
                $(this).attr("tabindex", c);
                c++;
            });
        }
        $("#submitprofile-item-detail").attr("tabindex", c);
        c++;
    }
    if ($("#savedInformationColumn").length === 1) {
        $("#savedInformationColumn a").each(function() {
            $(this).attr("tabindex", c);
            c++;
        });
    }
    if ($("#previousPage a").length === 1) {
        $("#previousPage a").attr("tabindex", c);
        c++;
    }
    if ($("#nextPage a").length === 1) {
        $("#nextPage a").attr("tabindex", c);
        c++;
    }
    if ($("#orderHistory").length === 1) {
        $("#orderHistory a").each(function() {
            $(this).attr("tabindex", c);
            c++;
        });
    }
    if ($("#lisubscribe").length === 1) {
        $("#lisubscribe").attr("tabindex", c);
        c++;
    }
    if ($("#termsAndConditionsLabel").length === 1) {
        var b;
        b = $("#termsAndConditionsLabel").parentsUntil("ul").last().attr("tabindex");
        if (b === undefined) {
            b = 33;
        }
        $("#termsAndConditionsLabel a").each(function() {
            $(this).attr("tabindex", b);
        });
    }
    $("#breadcrumb a").on("focus",
    function(d) {
        $(this).addClass("selectedControl");
    });
    $("#breadcrumb a").blur(function() {
        $(this).removeClass("selectedControl");
    });
    $(".accountContainer a").on("focus",
    function(d) {
        $(this).addClass("selectedControl");
    });
    $(".accountContainer a").blur(function() {
        $(this).removeClass("selectedControl");
    });
    $(".accountContainer :submit").on("focus",
    function(d) {
        $(this).addClass("selectedControl");
    });
    $(".accountContainer :submit").blur(function() {
        $(this).removeClass("selectedControl");
    });
    $(".accontContainer a").on("focus",
    function(d) {
        $(this).addClass("selectedControl");
    });
    $(".accontContainer a").blur(function() {
        $(this).removeClass("selectedControl");
    });
    $(".accontContainer :submit").on("focus",
    function(d) {
        $(this).addClass("selectedControl");
    });
    $(".accontContainer :submit").blur(function() {
        $(this).removeClass("selectedControl");
    });
    $(".ulcheckBoxFocus .removeOutLine").on("focus",
    function(d) {
        $(this).find("label").addClass("selectedControl");
    });
    $(".ulcheckBoxFocus .removeOutLine").blur(function() {
        $(this).find("label").removeClass("selectedControl");
    });
    $(".ulDivBoxFocus .removeOutLine").on("focus",
    function(d) {
        $(this).find("div").addClass("selectedControl");
    });
    $(".ulDivBoxFocus .removeOutLine").blur(function() {
        $(this).find("div").removeClass("selectedControl");
    });
    $("#newsletterSignup a").on("focus",
    function(d) {
        $(this).addClass("selectedControl");
    });
    $("#newsletterSignup a").blur(function() {
        $(this).removeClass("selectedControl");
    });
    $("#newsletterSignup :submit").on("focus",
    function(d) {
        $(this).addClass("selectedControl");
    });
    $("#newsletterSignup :submit").blur(function() {
        $(this).removeClass("selectedControl");
    });
}
function SetNewsletterInviteThanks() {
    if ($("#btnGoshopping").length === 1) {
        $("#btnGoshopping").focus();
    }
}
$(document).ready(function(m) {
    var o;
    ulWidth = 1030;
    ListWidth = 0;
    listNum = 0;
    padLR = 0;
    initPad = 0;
    newPad = 0;
    m("#navList li.nav-item").each(function() {
        var j = m(this);
        ListWidth += j.outerWidth();
        listNum += m(this).size();
        initPad = parseInt(m(this).css("padding-left"));
    });
    padLR = ((ulWidth - ListWidth) / listNum) / 2;
    newPad = padLR + initPad;
    m("#navList li.nav-item").css({
        "padding-left": newPad
    });
    m("#navList li.nav-item").css({
        "padding-right": newPad
    });
    m("#headerBar").trigger("click");
    SetTabIndexToAddressPage();
    SetNewsletterInviteThanks();
    m(":submit").on("focus",
    function(j) {
        m(this).addClass("selectedControl");
    });
    m(":submit").on("blur",
    function(j) {
        m(this).removeClass("selectedControl");
    });
    m(":button").on("focus",
    function(j) {
        m(this).addClass("selectedControl");
    });
    m(":button").on("blur",
    function(j) {
        m(this).removeClass("selectedControl");
    });
    m(".gift_card_landing").find("img").attr("tabindex", "31");
    m(".gift_card_landing").find("img").keypress(function(j) {
        if (j.keyCode == 13) {
            location.href = m(this).parent("a").attr("href");
        }
    });
    m(".have_card").attr("tabindex", "32");
    setTimeout(function() {
        m(".close-search").css("outline", "1");
    },
    10000);
    setTimeout(function() {
        m("#productDetailsAlsoLike ul li .item-details").css("display", "none");
        m("#productDetailsAlsoLike ul li .item-details").css("display", "block");
    },
    2000);
    m(".nav-item").click(function() {
        if (m(this).find("a").length != 0) {
            location.href = m(this).find("a").attr("href");
        }
    });
    m(".nav-item").focus(function() {
        var v = m(this);
        m(".nav-item").trigger("mouseleave");
        v.trigger("mouseover");
        var j = v.attr("tabindex");
        if (m(".show_megamenu").hasClass("DK-menu")) {
            m(".main-menu-link").parent("li").attr("tabindex", j);
        } else {
            m(".show_megamenu").find("li").attr("tabindex", j);
        }
        m("body").keydown(function(y) {
            var w = y.keyCode || y.which;
            if (w == 13) {
                if ((m(".show_megamenu li:focus").length) == 1) {
                    location.href = m(".show_megamenu li:focus").find("a").attr("href");
                } else {
                    if ((m(".nav-item:focus").find("a").length) != 0) {
                        location.href = m(".nav-item:focus").find("a").attr("href");
                    }
                }
            }
        });
        if (m(".nav-item:focus").attr("id") == "displaySearch") {
            m("#displaySearch").trigger("click");
        }
    });
    m(document).find("#productQuickviewModal").each(function() {});
    m(".category_bread_crumbs [href]").each(function() {
        m(this).attr("tabindex", "24");
        m(this).focus(function() {
            m(this).mouseover();
        }).bind("focusout",
        function() {
            m(this).mouseleave();
        });
    }).bind("keydown",
    function(j) {
        if (j.keyCode == 13) {
            location.href = m(this).attr("href");
        }
    }).bind("mouseover",
    function(j) {
        m(this).css("border", "1px solid #AB9259");
    }).bind("mouseleave",
    function(j) {
        m(this).css("border", "none");
    });
    m("#trendsAndCategoriesNav nav ul li").each(function() {
        m(this).attr("tabindex", "25");
    }).bind("keydown",
    function(j) {
        if (j.keyCode == 13) {
            location.href = m(this).children("a").attr("href");
        }
    });
    m("#viewFilterOptions #filterSortContainer #filterLabel").focus(function() {
        m(this).trigger("mouseover");
    });
    m("#viewFilterOptions #filterSortContainer #sortByLabel").focus(function() {
        m(this).trigger("mouseover");
    });
    if (m(this).find("#colorColumn").length > 0) {
        m(this).find("#colorColumn").children(".swatch-outline").children("a").each(function() {
            m(this).focus(function() {
                m(this).mouseover();
            }).bind("focusout",
            function() {
                m(this).mouseleave();
            });
            m(this).attr("tabindex", "26");
        }).bind("keydown",
        function(j) {
            if (j.keyCode == 13) {
                location.href = m(this).attr("href");
            }
        }).bind("mouseover",
        function(j) {
            m(this).addClass("ui-state-hover");
        }).bind("mouseleave",
        function() {
            m(this).parent().css("border", "none");
        });
    }
    if (m(this).find(".priceColumn").length > 0) {
        m(this).find(".priceColumn").children("label").children("a").each(function() {
            m(this).focus(function() {
                m(this).mouseover();
            }).bind("focusout",
            function() {
                m(this).mouseleave();
            });
            m(this).removeAttr("tabindex").attr("tabindex", "26");
        }).bind("keydown",
        function(j) {
            if (j.keyCode == 13) {
                event.preventDefault();
                m(this).trigger("click");
                location.href = m(this).attr("href");
            }
            if (j.keyCode == 32 || j.keyCode == 0) {
                event.preventDefault();
                m(this).trigger("click");
                location.href = m(this).attr("href");
            }
        }).bind("mouseover",
        function(j) {
            m(this).parent().css("border", "2px solid #AB9259");
        }).bind("mouseleave",
        function(j) {
            m(this).parent().css("border", "none");
        });
    }
    m("#sortbydropdown-outer > #sortbydropdown").children().children("a").each(function() {
        m(this).attr("tabindex", "27");
        m(this).focus(function() {
            m(this).mouseover();
        }).bind("focusout",
        function() {
            m(this).mouseleave();
        });
    }).bind("keydown",
    function(j) {
        if (j.keyCode == 13) {
            event.preventDefault();
            m(this).trigger("click");
            location.href = m(this).attr("href");
        }
        if (j.keyCode == 32 || j.keyCode == 0) {
            event.preventDefault();
            m(this).trigger("click");
            location.href = m(this).attr("href");
        }
    }).bind("mouseover",
    function(j) {
        m(this).css("border", "2px solid #AB9259");
    }).bind("mouseleave",
    function(j) {
        m(this).css("border", "none");
    });
    m("#viewFilterOptions #imageSizeIcons .img-size-icon").each(function() {
        m(this).attr("tabindex", "28");
    }).bind("keydown",
    function(j) {
        if (j.keyCode == 13) {
            location.href = m(this).parent("a").attr("href");
        }
    });
    m("#categoryHero img").each(function() {
        m(this).attr("tabindex", "30");
    });
    m("body").click(function() {
        m("body").trigger("focusout");
    });
    m("#headerLang").attr("tabindex", "1");
    m("#languageSelect").attr("tabindex", "1");
    m(".ui-dialog-buttonpane").attr("tabindex", "1");
    m("#languageSelect").find("div").each(function() {
        if (m(this).attr("id") != "languageSelectArrow" && m(this).attr("class") != "active_lang") {
            m(this).attr("tabindex", "1");
        }
    });
    m("#languageSelect").focus(function() {
        o = m(this);
        m("#languageSelect").trigger("mouseover");
    });
    m("#headerSignIn").attr("tabindex", "2");
    m("#signInBox").attr("tabindex", "2");
    m("#signInDropDownlogin,#signInBoxPassword,.createButton,#facebookButton,#twitterButton,#forgotPasswordDrop a, #signInDropDown #autoLogin, #signInDropDown .newwindowanchor, #signInDropDown #loginUser").attr("tabindex", "2");
    m("#headerAccountLink,#myAccountOptions li").attr("tabindex", "2");
    m(".logoimg").find("img").attr("tabindex", "4");
    m(".shoppingBagHeader").attr("tabindex", "3");
    m("#miniCartItems").find(".removeFromBag").parent().each(function() {
        m(this).attr("tabindex", "3");
    });
    m(".mini-cart-checkout").attr("tabindex", "3");
    m(".mini-cart-view-bag").attr("tabindex", "3");
    var l = 4;
    m(".nav-item").each(function() {
        l++;
        m(this).attr("tabindex", l);
    });
    m(".carousel-item").attr("tabindex", l + 3);
    m("#heroImage ul li").attr("tabindex", l + 3);
    m("#Table_01").find("img").each(function() {
        m(this).attr("tabindex", l + 3);
    });
    m(".hover-details").attr("tabindex", l + 3);
    m("#searchField").find(".sbholder").attr("tabindex", l);
    m("#searchField").find(".sbToggle").removeAttr("tabindex");
    m("#searchText").attr("tabindex", l + 1);
    m("#searchSubmit").attr("tabindex", l + 2);
    m(".close-search").attr("tabindex", l + 3);
    m("#footerNavMenu ul li ul li").attr("tabindex", "111");
    m("#mailingListSignUpForm #mailingListSignUplogin,#storeFinderForm #storeLocatorAddressField").attr("tabindex", "110");
    m("input[name='selectedViewFormUp']").attr("tabindex", "112");
    m("input[name='selectedViewFormDown']").attr("tabindex", "112");
    m("#headerLang,#headerSignIn,.shoppingBagHeader").focus(function() {
        o = m(this);
        if (m(this).attr("id") == "headerSignIn") {
            m(this).trigger("mouseover");
            m("#languageSelect").hide();
        } else {
            m(this).trigger("mouseover");
        }
    });
    m("#myAccountOptions li").focus(function() {
        o = m(this).parent("ul").parent();
    });
    m("#headerAccountLink").focus(function() {
        m(this).trigger("mouseover");
        o = m(this);
    });
    m("input[name='selectedViewFormUp']").focus(function() {
        o = m(this);
    });
    m("input[name='selectedViewFormDown']").focus(function() {
        o = m(this);
    });
    m("#miniCartItems").find(".removeFromBag").parent().focus(function() {
        o = m(this).find(".removeFromBag");
    });
    m(".mini-cart-checkout").focus(function() {
        o = m(this);
    });
    m(".mini-cart-view-bag").focus(function() {
        m(this).trigger("mouseover");
        o = m(this);
    });
    m("#forgotPasswordDrop a").focus(function() {
        o = m(this).parent();
    });
    m(".details_lnk").focus(function() {
        o = m(this);
    });
    m("#loginUser").focus(function() {
        o = m(this);
    });
    m("#searchText,#searchSubmit").focus(function() {
        o = m(this);
    });
    m(".carousel-item").focus(function() {
        o = m(this);
    });
    m("#headerLang,#headerSignIn,.shoppingBagHeader").focusout(function() {
        m(this).trigger("mouseleave");
    });
    m("#heroImage ul li").focus(function() {
        o = m(this);
        m("body").keydown(function(v) {
            var j = v.keyCode || v.which;
            if (j == 13) {
                location.href = o.find("a").attr("href");
            }
        });
    });
    m("#siteTitleImage").focus(function() {
        o = m(this);
    });
    m(".hover-details").focus(function() {
        o = m(this);
    });
    m("#footerNavMenu ul li ul li").focus(function() {
        o = m(this);
    });
    m("#mailingListSignUplogin,#storeLocatorAddressField").focus(function() {
        o = m(this);
    });
    m("#mailingListSignUplogin,#storeLocatorAddressField").blur(function() {
        o = undefined;
    });
    m("#footerNavMenu ul li ul li").each(function() {
        if (m(this).find("span").text() == "FOLLOW US") {
            m(this).removeAttr("tabindex");
        }
    });
    m(".sub-menu li").each(function() {
        m(this).removeAttr("tabindex");
    });
    m("body").keydown(function(v) {
        var j = v.keyCode || v.which;
        if (o === "undefined" || o === undefined) {
            o = m(v.srcElement);
        }
        if (j == 13 && o != "undefined" && o != undefined) {
            if (o.hasClass("createButton")) {
                location.href = m(".createButton").parent().attr("href");
            }
            if (o.attr("id") == "mailingListSignUplogin") {
                m("#submitMailingList").trigger("click");
            }
            if (o.attr("id") == "siteTitleImage") {
                location.href = "/";
            }
            if (o.attr("class") == "carousel-item") {
                location.href = m("div:focus").find("a").attr("href");
            }
            if (o.attr("id") == "headerSignIn") {
                m("button:focus").trigger("click");
                m("div:focus").trigger("click");
                m("a:focus").trigger("click");
            }
            if (o.attr("id") == "languageSelect") {
                m("div:focus").find("a").trigger("click");
            }
            if (m(".close-search:focus").length != 0) {
                m(".searchFieldContainer").hide();
            }
            if (o.attr("class") == "hover-details") {
                location.href = o.find("a").attr("href");
            }
            if (o.attr("id") == "searchText") {
                m("#searchSubmit").trigger("click");
            }
            if (o.attr("id") == "searchSubmit") {
                m("#searchSubmit").trigger("click");
            }
            if (o.attr("tabindex") == "111") {
                location.href = o.find("a").attr("href");
            }
            if (o.attr("id") == "forgotPasswordDrop") {}
            if (o.attr("class") == "details_lnk") {
                o.find("a").trigger("click");
            }
            if (o.attr("id") == "loginUser") {
                o.trigger("click");
            }
            if (o.attr("name") == "selectedViewFormUp") {
                m("#collapseSubNav").trigger("click");
                setTimeout(function() {
                    m("input[name='selectedViewFormDown']").focus();
                },
                500);
            }
            if (o.attr("name") == "selectedViewFormDown") {
                m("#showSubNav").trigger("click");
                setTimeout(function() {
                    m("input[name='selectedViewFormUp']").focus();
                },
                500);
            }
            if (o.attr("class") == "removeFromBag") {
                o.trigger("click");
            }
            if (o.hasClass("mini-cart-checkout")) {
                o.trigger("click");
            }
            if (o.hasClass("mini-cart-view-bag")) {
                o.trigger("click");
            }
            if (o.attr("id") == "myAccountOptions") {
                location.href = o.find("li:focus").find("a").attr("href");
            }
            if (o.attr("id") == "headerAccountLink") {
                location.href = o.find("a").attr("href");
            }
            if ((v.srcElement).href !== "undefined" && (v.srcElement).href !== undefined) { (m(v.srcElement))[0].click();
            }
        }
    });
    m("#accountCompleteForm").find("#password").attr("tabindex", "30");
    m("#accountCompleteForm").find("#confirmPassword").attr("tabindex", "30");
    m("#resetPasswordEmailForm").find("#password").attr("tabindex", "30");
    m("#resetPasswordEmailForm").find("#confirmPassword").attr("tabindex", "30");
    m("#orderstatus").find("#emailId").attr("tabindex", "30");
    m("#orderstatus").find("#orderId").attr("tabindex", "30");
    m("#orderstatus").find(".whats_thisContainer").attr("tabindex", "31");
    m("#orderstatus").find("#submit").attr("tabindex", "32");
    m("#singin").find("#password").attr("tabindex", "32");
    m("#singin").find("#login").attr("tabindex", "32");
    m("#singin").find("#forgotPasswordDrop").attr("tabindex", "32");
    m("#singin").find("#submit").attr("tabindex", "32");
    m("#singin").find(".order_Remember").attr("tabindex", "32");
    m("#accountCompleteForm #password,#accountCompleteForm #confirmPassword").attr("tabindex", "30");
    setTimeout(function() {
        m("#resetPasswordEmailForm,#accountCompleteForm").find(".sbHolder").removeAttr("tab-index");
        m("#resetPasswordEmailForm,#accountCompleteForm").find(".sbToggle").removeAttr("tabindex");
        m("#resetPasswordEmailForm,#accountCompleteForm").find(".sbHolder").attr("tabindex", "31");
        m("#accountCompleteForm #answer").attr("tabindex", "32");
        m("#resetPasswordEmailForm #strengthContainer").attr("tabindex", "31");
        m("#resetPasswordEmailForm #answer").attr("tabindex", "32");
        m("#termsContainer,#rememberContainer").attr("tabindex", "33");
        m("input[name='completeAccount']").attr("tabindex", "34");
        m("#resetEmailSubmit").attr("tabindex", "33");
        m(".orderStatusMainContainer").find("#twitterButton").attr("tabindex", "32");
        m(".orderStatusMainContainer").find("#facebookButton").attr("tabindex", "32");
    },
    2000);
    m("#resetPasswordEmailForm #strengthContainer,#accountCompleteForm #strengthContainer").focus(function() {
        m(this).find("a").trigger("mouseover");
    });
    m("#resetPasswordEmailForm #strengthContainer,#accountCompleteForm #strengthContainer").focusout(function() {
        m(this).find("a").trigger("mouseleave");
    });
    m("#accountCompleteForm").find("#strengthContainer").attr("tabindex", "30");
    m("#accountCreation").find("#termsAndConditionsLabel a").attr("tabindex", "46");
    m(".slides").children().find("a").bind("touchstart",
    function() {
        var j = "false";
        var v = m(this);
        m(".slides").children().find("a").bind("touchmove",
        function() {
            j = "true";
        });
        setTimeout(function() {
            if (v.attr("href") != "#") {
                if (j == "false") {
                    location.href = v.attr("href");
                }
            }
        },
        400);
    });
    var f = m("#CheckSecureLogin").val();
    var e = m("#savedAddress").val();
    if (f != undefined) {
        if (! (m(".checkout-container").length > 0)) {
            m.ajax({
                url: "/includes/ajax_form_submit_login.jsp",
                type: "POST",
                dataType: "html",
                success: function(v) {
                    var j = m.trim(f);
                    if (j == "true") {
                        m("#headerSignIn").html(v);
                    } else {
                        if (j == "false") {
                            m("#headerAccountLink").html(v);
                        }
                    }
                    formPlaceholderFix();
                    m("#itemsInCartNotifier").html("<div class='itemsInCartNotifier_span'>" + m.trim(m("#orderitemcount").text()) + "</div>");
                }
            });
        }
    }
    var k = location.pathname;
    if ((k == "/index.jsp") || (k == "/")) {
        if (m("li").hasClass("deptSelected")) {
            m("li").removeClass("deptSelected");
        }
    }
    if (m("#resetPassword").hasClass("resetPasswordSection")) {
        if (m("div").hasClass("emailErrors")) {
            m("#login").addClass("field-missing-color");
            m("#loginLabel").addClass("field-missing-color");
        }
    }
    var u = m(window).width() + "px";
    m("#heroContainer #heroImage").width(u);
    m("#heroContainer .slides > li").width(u);
    m("#heroContainer .slides > li > img").width(u);
    m("#storeFinderForm #StoreFinderSearchBtn").on("click",
    function() {
        var j = document.getElementById("storeLocatorAddressField").value;
        localStorage.setItem("storeLocatorAddressField", j);
        m("#mailingListSignUpForm #login").removeClass("form-field-large, field-missing-color");
        m("#mailingListSignUpForm #submitMailingList").removeClass("field-missing-color");
        if (m("#mailingListSignUpForm").find(".field-missing-text")) {
            m("#mailingListSignUpForm").find(".field-missing-text").css("display", "none");
        }
        if (m("#storeFinderForm").find(".field-missing-text")) {
            m("#storeFinderForm").find(".field-missing-text").css("display", "block");
        }
    });
    m("#mailingListSignUpForm #submitMailingList").on("click",
    function() {
        m("#storeFinderForm #storeLocatorAddressField").removeClass("form-field-large, field-missing-color");
        m("#storeFinderForm #StoreFinderSearchBtn").removeClass("field-missing-color");
        if (m("#mailingListSignUpForm").find(".field-missing-text")) {
            m("#mailingListSignUpForm").find(".field-missing-text").css("display", "block");
        }
        if (m("#storeFinderForm").find(".field-missing-text")) {
            m("#storeFinderForm").find(".field-missing-text").css("display", "none");
        }
    });
    m(document).on("click", "a[rel$='external'], a[rel$='_blank']",
    function() {
        this.target = "_blank";
    });
    m(document).on("change", ".SelectQtyVal",
    function(v) {
        var j = m(this).closest("form").attr("id");
        m("#" + j).submit();
        v.preventDefault();
    });
    toolTip(".fav-icon", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".share-icon", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".view-icon", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".view-icon-outfit", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".fave", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".view", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".share", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".view_icon", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".fave-share-product .fave", "right-15 top+12", "center bottom", "light-arrow-top");
    toolTip(".unfavorite-heart", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".favorite-heart", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".Shopcarttooltip", "right-60 top-20", "center", "light-arrow-right");
    m("input[type='password'], input.creditCard").each(function() {
        m(this).attr("autocomplete", "off");
    });
    initBindings();
    var n = 0;
    m("ul#navList .nav-item").each(function() {
        n += m(this).outerWidth(true);
    });
    m("#search").focus(function() {
        schval = m(this).val();
        if (schval == "Search") {
            m(this).val("");
        }
    });
    m("#search").blur(function() {
        schval = m(this).val();
        if (schval == "") {
            m(this).val("Search");
        }
    });
    m("#searchSubmit").on("click",
    function(v) {
        var j = m("#searchText").val();
        if (j == "" || j == null || j == "Please Enter Valid Search Term" || !/Chrome[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
            setTimeout(function() {
                _gaq.push(["_trackEvent", "Search", "keyword", j]);
            },
            10);
        }
        if (j == "" || j == null || j == "Please Enter Valid Search Term") {
            v.preventDefault();
            m("#searchText").val("Please Enter Valid Search Term");
        } else {
            if (j != "" || j != null || j != "Please Enter Valid Search Term") {}
        }
    });
    m("#searchText").on("keypress",
    function(v) {
        var v = window.event || v;
        var j = v.charCode || v.keyCode;
        return (j == 47 || j == 92 || j == 124) ? false: true;
    });
    m("#searchText").on("focus",
    function(j) {
        if (m("#searchText").val("Please Enter Search Term")) {
            m("#searchText").val("");
        }
    });
    m("#searchField").find("#searchText").on("keydown",
    function(v) {
        if (v.which === 13) {
            var j = m("#searchText").val();
            setTimeout(function() {
                _gaq.push(["_trackEvent", "Search", "keyword", j]);
            },
            10);
            if (j == "" || j == null || j == "Please Enter Valid Search Term") {
                v.preventDefault();
                m("#searchText").val("Please Enter Valid Search Term");
                m("#searchText").blur();
            } else {
                if (j != "" || j != null || j != "Please Enter Valid Search Term") {
                    m("#searchField").submit();
                }
            }
        }
    });
    m("ul.dropdown li").hover(function() {
        m(this).addClass("hover");
        m("ul:first", this).css("visibility", "visible");
    },
    function() {
        m(this).removeClass("hover");
        m("ul:first", this).css("visibility", "hidden");
    });
    m(".addToCartButton").click(function(j) {
        addToCartAjax(m(this));
        j.preventDefault();
    });
    m(document).on("click", ".addToCartSerialButton",
    function(j) {
        addToCartSerialized(m(this).closest("form").serialize(), m(this).closest("form").attr("action"));
        j.preventDefault();
    });
    m(".facetRefinement").bind("touchstart",
    function() {
        var v = m("#refinementName").val();
        var j = m("#filterName").val();
        _gaq.push(["_trackEvent", "Search", "Refinement", v]);
    });
    m("#headerSignIn").hover(function() {
        m("#miniCartContiainer,#languageSelect").hide();
        mouse_is_inside = true;
    });
    m("#headerSignIn").mouseenter(function(j) {
        m("#largeOutfitCarousel").css("left", "-311px");
        if (m(".category-large-container ").hasClass("onlyOneProd")) {
            m(".lg-grid-prev").hide();
            m(".lg-grid-next").hide();
        }
        if (loadParentIframe === 0) {
            loadParentIframe = 1;
            m.getScript("/js/parentIframe.js",
            function(v, y, w) {});
        }
        m("#signInBox").addClass("hoverActive");
        m("#signInBox,#signInArrow").css("visibility", "visible");
        m(".sign-in-arrow").css("visibility", "visible");
        m("#signInBoxEmail").focus();
        m("#signInBox,#signInArrow").show("fade", 200);
        m("#miniCartContiainer,#languageSelect").hide();
        if (m(".category-large-container-Outfit").is(":visible")) {
            j.stopPropagation();
            if (m.browser.msie && m.browser.version == 9) {
                m("#largeOutfitCarousel").stop().css("left", "-459px");
            }
            m("#largeOutfitCarousel").stop().css("left", "-459px");
        }
        m("#signInDropDownlogin").removeClass("signinWidth");
        if ((m("#signInDropDownlogin").outerWidth()) > 300) {
            setTimeout(function() {
                m("#signInDropDownlogin").addClass("signinWidth");
            },
            400);
        }
    });
    m("#headerSignIn").mouseleave(function(j) {
        hideSignInDetails();
    });
    m("form#signInDropDown").find("#loginUser").on("click",
    function() {
        var j = m("#signInBoxEmail").val();
        if (j == "") {
            m("#signInBoxEmail").focus();
        }
    });
    var q = "no";
    m("#signInBox").live("mouseenter",
    function(j) {
        m("#signInBox").addClass("hoverActive");
    });
    m("#signInBox,#signInArrow").live("mouseleave",
    function(j) {
        hideSignInDetails();
    });
    m("#sign_in_close").click(function() {
        m("#signInBox,#signInArrow").css("display", "none");
        m("#signInBox,#signInArrow").hide("fade", 200);
        m("#miniCartContiainer,#languageSelect").hide();
    });
    m("#headerAccountLink").mouseover(function(j) {
        m("#myAccountBox").show("fade", 200);
        m(".sign-in-arrow").css("visibility", "visible");
        var v = 57 + (m("#headerAccountLink a").width() / 2);
        m("#myAccountBox .myaccount-arrow").css("right", v);
        m("#myAccountBox").css("display", "block");
        m("#miniCartContiainer,#languageSelect").hide();
    });
    m("#headerAccountLink").mouseleave(function(j) {
        hideMyAccountDetails();
    });
    m("#myAccountBox").live("mouseover",
    function(j) {
        m(this).addClass("overActive");
    });
    m("#myaccount_close").click(function() {
        m("#myAccountBox").css("display", "none");
        m("#myAccountBox").hide("fade", 200);
        m(".sign-in-arrow").css("visibility", "visible");
        m("#miniCartContiainer,#languageSelect").hide();
    });
    m("#myAccountBox").live("mouseleave",
    function() {
        hideMyAccountDetails();
    });
    m("#shoppingBagHeader").hover(function() {
        m("#signInBox,#signInArrow,#languageSelect,#myAccountBox").hide();
        mouse_is_inside = true;
    });
    m("#shoppingBagHeader").mouseover(function(j) {
        m("#miniCartContiainer").addClass("hoverActive");
        m("#miniCartContiainer").show("fade", 200);
        if (mousebagFirsttime == "yes") {
            if (m("#miniCartItems_scroll").height() > 200) {
                m("#miniCartItems_scroll").jScrollPane();
            }
            mousebagFirsttime = "no";
        }
        m("#signInBox,#signInArrow,#languageSelect,#myAccountBox").hide();
        m(this).addClass("overActive");
    });
    m(".shoppingBagHeader").mouseleave(function(j) {
        m("#miniCartContiainer").removeClass("hoverActive");
        m(this).removeClass("overActive");
        setTimeout(function() {
            if (!m(".shoppingBagHeader").hasClass("overActive")) {
                m("#miniCartContiainer").fadeOut(300,
                function() {});
            }
        },
        3000);
    });
    function r() {
        m("#miniCartContiainer, #shoppingBagHeader").hover(function() {
            mouse_is_inside = true;
        },
        function() {
            mouse_is_inside = false;
        });
        m("body").mouseup(function() {
            if (!mouse_is_inside) {
                m("#miniCartContiainer").hide("fade", 200);
            }
        });
        m(document).on("keyup",
        function(j) {
            if (j.keyCode === 27) {
                m("#miniCartContiainer").hide("fade", 200);
            }
        });
    }
    m(".mini-cart-view-bag").on("click",
    function() {
        window.location = "/store/templates/checkout/shop_cart.jsp";
    });
    m("body").on("click", ".mini-cart-checkout",
    function(j) {
        m("form#miniBagcheckoutform").submit();
    });
    m("body").on("click", ".mini-cart-viewfull",
    function(j) {
        m("#miniBagfullview").submit();
    });
    m("body").on("click", ".mini-cart-icon",
    function(j) {
        m("#miniBagicon").submit();
    });
    dropDownOffset();
    m(".verifyDelete").click(function(v) {
        v.preventDefault();
        var j = m(this).attr("rel");
        var w = m(this).attr("href");
        m("#" + j).dialog({
            resizable: false,
            height: 140,
            modal: true,
            buttons: {
                Ok: function() {
                    m(this).dialog("close");
                    window.location.href = w;
                },
                Cancel: function() {
                    m(this).dialog("close");
                    return false;
                }
            }
        });
    });
    var h = m(window).height();
    var d = m("header").height();
    var b = m("footer").height();
    var t = h - d - b - 5;
    m(".fullSize").height(t);
    m(".showSignIn").each(function() {
        var j = m('<div id="checkoutSigninModal"></div>').load(contextRoot + "/modals/soft_login_modal.jsp").dialog({
            modal: true,
            of: window,
            autoOpen: false,
            closeOnEscape: true,
            closeText: "Close Window",
            dialogClass: "no-close",
            draggable: false,
            resizable: false,
            width: 395,
            show: {
                effect: "fade",
                duration: 300
            },
            hide: {
                effect: "fade",
                duration: 300
            }
        });
        m(this).click(function() {
            j.dialog("open");
            return false;
        });
    });
    m(document).on("click", ".dialog-close-button, div.ui-widget-overlay",
    function(j) {
        m(document).find(".ui-dialog-content").dialog("close");
        m(".tooltipster-fade-show").css("opacity", 0);
        j.stopImmediatePropagation();
    });
    m(document).on("click", ".store-results-dialog-close-button, div.ui-widget-overlay",
    function() {
        var j = m(".ui-dialog").find("#locateInStore");
        if (j.length != 0) {
            m("#locateInStore").dialog("close");
        }
        m(document).find("#locateInStoreResults-popup").dialog("close");
        m(document).find("#locateInStore_pdp").dialog("close");
    });
    m(document).on("click", ".find-store-dialog-close-button, div.ui-widget-overlay",
    function() {
        m(document).find("#locateInStore").dialog("close");
    });
    m(document).on("click", ".sharePopUp-dialog-close-button, div.ui-widget-overlay",
    function() {
        m(document).find(".shareActive").dialog("close");
    });
    m("#displaySearch").click(function() {
        m(".searchFieldContainer").fadeIn("fast");
        m("#displaySearch").addClass("active");
        m("body").addClass("searchActive");
        if (m(".searchFieldContainer").find(".sbHolder").length > 0) {
            m(".searchFieldContainer").find(".sbHolder").removeAttr("tab-index").attr("tabindex", "14");
            m(".searchFieldContainer").find(".sbToggle,.sbSelector").removeAttr("tab-index").removeAttr("tabindex");
            m(".searchFieldContainer").find(".sbHolder").on("focus",
            function() {
                if (event.keyCode == 13) {}
            });
        }
        m("#searchText").focus();
    });
    m(".close-search").click(function() {
        m(".searchFieldContainer").fadeOut("fast");
        m("#displaySearch").removeClass("active");
        m("body").removeClass("searchActive");
        m("#searchDropDown").css("display", "none");
    });
    m("#searchInputField").keypress(function() {
        m("#searchDropDown").css("display", "block");
    });
    var c = (navigator.userAgent.match(/iPad/i) != null);
    if (c) {
        var g = function() {
            m("*").on("touchstart",
            function() {
                m(this).trigger("hover");
            }).on("touchend",
            function() {
                m(this).trigger("hover");
            });
        };
        g();
        m("select").bind("touchstart change",
        function(j) {
            m("#headerBar").css("top", "0px");
        });
        m("#newsletterSignup input[type='text'],#newsletterSignup input[type='password']").focus(function() {
            m("#headerBar").css("position", "static");
        });
        m("#newsletterSignup input[type='text'],#newsletterSignup input[type='password']").blur(function() {
            m("#headerBar").css("position", "fixed");
        });
        m(".view-icon, .view-icon-outfit, .view, .view_icon, .view-icon-outfit1").bind("touchstart click",
        function(j) {
            toolTip("close");
            m(".ui-tooltip").css("display", "none");
        });
        m(".category-list").find("li").each(function(j) {
            m(this).bind("touchstart click mouseover",
            function(v) {
                m(this).find(".favorite-actions").find("a.view-icon, a.view_icon, .view-icon-outfit, .view").tooltip("open");
            });
            m(this).bind("touchstart click mouseleave",
            function(v) {
                m(this).find(".favorite-actions").find("a.view-icon, a.view_icon, .view-icon-outfit, .view").tooltip("close");
            });
        });
        m(document).bind("touchstart click",
        function(v) {
            var j = m("#categoryList li");
            if (!j.is(v.target) && j.has(v.target).length === 0) {
                m(this).find(".favorite-actions").find("a.view-icon, a.view_icon, .view-icon-outfit, .view").tooltip("close");
            }
        });
        m(document).bind("touchstart click",
        function(v) {
            var j = m(v.target);
            if (!j.is("#signInBox")) {
                if (m(v.target).closest("#signInBox").length == 0) {
                    if (m("#signInBox").hasClass("hoverActive")) {
                        m("#signInBox").removeClass("hoverActive");
                        m("#signInBox,#signInArrow").hide("fade", 200);
                    }
                }
            }
            if (!j.is("#languageSelect")) {
                if (m(v.target).closest("#languageSelect").length == 0) {
                    if (m("#languageSelect").hasClass("hoverActive")) {
                        m("#languageSelect").removeClass("hoverActive");
                        m("#languageSelect").hide("fade", 200);
                    }
                }
            }
            if (!j.is("#miniCartContiainer")) {
                if (m(v.target).closest("#miniCartContiainer").length == 0) {
                    if (m("#miniCartContiainer").hasClass("hoverActive")) {
                        m("#miniCartContiainer").removeClass("hoverActive");
                        m("#miniCartContiainer").hide("fade", 200);
                    }
                }
            }
        });
        var p = "<?PHP echo DIR_WS_TEMPLATE_IMAGES?>MK_LOGO_IPAD.png";
        m("#logoContainer .logoimg").find("img").attr("src", p);
        m("#largeOutfitCarousel").parents().find("#productGrids").css({
            "margin-bottom": "-40px"
        });
        m("#largeProductCarousel").parents().find("#productGrids").css({
            "margin-bottom": "-37px"
        });
    }
});
$(document).ready(function() {
		$("#navList .nav-item").mouseover(function(b) {
			$("#navList .nav-item").removeClass("nav-item-hover");
			$(this).addClass("nav-item-hover");
		});
		$("#navList .nav-item,#footer_menu .dept-dd").mouseover(function(c) {

			$("#footer_menu, .dept-dd").css("display", "block");
			var b = this.id;
			$("#footer_menu #" + b).addClass("show_megamenu");
			$("#" + b).addClass("nav-item-hover");
			$("#footer_menu #" + b).css({
				display: "block"
			});
			$("#footer_menu #" + b).css({
				visibility: "visible"
			});
			$("#footer_menu #" + b).find(".arrow").css({
				visibility: "visible"
			});
		});
		$("#navList .nav-item,#footer_menu .dept-dd").mouseout(function() {
			var b = this.id;
			$("#footer_menu, .dept-dd").css("display", "none");
			$("#footer_menu #" + b).removeClass("show_megamenu");
			$("#" + b).removeClass("nav-item-hover");
			$("#footer_menu").css({
				display: "none"
			});
			$("#footer_menu #" + b).css({
				visibility: "hidden"
			});
			$("#footer_menu #" + b).css({
				display: "none"
			});
			$("#footer_menu #" + b).find(".arrow").css({
				visibility: "hidden"
			});
		});

});

function abc(b) {
    $("#footer_menu #" + b).mouseover(function() {
        $("#footer_menu #" + b).show();
    });
    $("#footer_menu #" + b).mouseout(function() {
        $("#footer_menu #" + b).css("display", "block");
    });
}
function soft_login_close_function() {
    $(document).find(".ui-dialog-content").dialog("close");
}
function initSlider(b, d) {
    var f = b;
    var g = 140;
    if (d >= 0) {
        var e = 4 - d;
        if (d == 2 || d < 2) {
            if (f.find(".spotlight-slider").find(".slides > li").length > 3) {
                e = 3;
                var c = (e * g) + 20;
                f.find(".spotlight-slider").width(c);
                f.find(".flexslider").flexslider({
                    animation: "slide",
                    animationLoop: false,
                    itemWidth: g,
                    slideshow: false,
                    pauseOnHover: true,
                    minItems: 1,
                    itemMargin: 5,
                    maxItems: e
                });
                f.find(".flex-control-nav ").remove();
            } else {
                if (f.find(".spotlight-slider").find(".slides > li").length == 3) {
                    e = 3;
                    var c = (e * g) + 20;
                    f.find(".spotlight-slider").width(c);
                    f.find(".flex-control-nav ").remove();
                } else {
                    if (f.find(".spotlight-slider").find(".slides > li").length == 2) {
                        e = 2;
                        var c = (e * g) + 20;
                        f.find(".spotlight-slider").width(c);
                        f.find(".flex-control-nav ").remove();
                    } else {
                        if (f.find(".spotlight-slider").find(".slides > li").length == 1) {
                            e = 1;
                            var c = (e * g) + 20;
                            f.find(".spotlight-slider").width(c);
                            f.find(".flex-control-nav ").remove();
                        } else {
                            f.find(".spotlight-slider").width("0");
                        }
                    }
                }
            }
        } else {
            if (f.find(".spotlight-slider").find(".slides > li").length > 1) {
                e = 1;
                var c = (e * g) + 20;
                f.find(".spotlight-slider").width(c);
                f.find(".flexslider").flexslider({
                    animation: "slide",
                    itemWidth: g,
                    slideshow: false,
                    pauseOnHover: true,
                    minItems: 1,
                    itemMargin: 5,
                    maxItems: e
                });
                f.find(".flex-control-nav ").remove();
            } else {
                if (f.find(".spotlight-slider").find(".slides > li").length == 1) {
                    e = 1;
                    var c = (e * g) + 20;
                    f.find(".spotlight-slider").width(c);
                    f.find(".flex-control-nav ").remove();
                } else {
                    f.find(".spotlight-slider").width("0");
                }
            }
        }
    }
}
function formPlaceholderFix() {
    if (document.createElement("input").placeholder == undefined) {
        $("input[type='password']").each(function() {
            var b = $(this).attr("placeholder");
            if (b != "") {
                $(this).focus(function() {
                    var c = $(this).val();
                    if (c == b) {
                        $(this).val("");
                    }
                    $(this)[0].type = "password";
                });
                $(this).blur(function() {
                    var c = $(this).val();
                    if (c == "") {
                        $(this).val(b);
                        $(this)[0].type = "text";
                    }
                });
            }
        });
        $("[placeholder]").focus(function() {
            var b = $(this);
            if (b.val() == b.attr("placeholder")) {
                b.val("");
                b.removeClass("placeholder");
            }
        }).blur(function() {
            var b = $(this);
            if (b.val() == "" || b.val() == b.attr("placeholder")) {
                b.addClass("placeholder");
                b.val(b.attr("placeholder"));
            }
        }).blur();
        $("[placeholder]").parents("form").submit(function() {
            $(this).find("[placeholder]").each(function() {
                var b = $(this);
                if (b.val() == b.attr("placeholder")) {
                    b.val("");
                }
            });
        });
    }
}
function addToCartAjax(c) {
    var b = false;
    if (isProductPickerType()) {
        b = checkPickerOptions() && checkQuantityGt0();
    } else {
        b = checkQuantityGt0();
    }
    if (b) {
        href = c.attr("href");
        $.get(href,
        function(d) {
            if ($(d).find("#item_description > .ui-widget").children().length == 0) {
                $(".ui-dialog-content").dialog("close");
                $.ajax({
                    url: "/mff/includes/miniCart/mini-cart.jsp",
                    success: function(e) {
                        $("#headerCart").empty().append(e);
                        initBindings();
                        miniCartDirection("down");
                        $("html, body").animate({
                            scrollTop: 0
                        },
                        "slow");
                    }
                });
            } else {
                $("#item_num").after().append($(d).find("#item_description > .ui-widget").html());
            }
        });
    }
}
function addToCartSerialized(d, b) {
    var c = false;
    c = checkPickerOptions() && checkQuantityGt0();
    if (c) {
        $.ajax({
            url: b,
            type: "post",
            data: d,
            success: function(e) {
                if ($(e).find("#errorMessagesPDP").children().length == 0) {
                    $(".ui-dialog-content").dialog("close");
                    $(".item_descriptionPDP > .ui-widget").empty();
                    $("#headerCart").empty().append(e);
                    initBindings();
                    miniCartDirection("down");
                    $("html, body").animate({
                        scrollTop: 0
                    },
                    "slow");
                } else {
                    $("#errorMessagesPDP").html($(e).find("#errorMessagesPDP").html());
                }
            }
        });
    }
}
function miniCartDirection(b) {
    if (b == "down") {
        $("#miniCart").slideDown("fast",
        function() {});
    } else {
        $("#miniCart").slideUp("fast",
        function() {});
    }
}
function wishListDirection(b) {
    if (b == "down") {
        $("#wishList").slideDown("fast",
        function() {});
    } else {
        $("#wishList").slideUp("fast",
        function() {});
    }
}
function initBindings() {
    $("#headerCart").unbind("click");
    $("#headerCart").click(function(b) {
        if ($("#miniCart").is(":visible")) {
            miniCartDirection("up");
            b.preventDefault();
            b.stopPropagation();
        } else {
            miniCartDirection("down");
            b.preventDefault();
            b.stopPropagation();
        }
    });
    $("#miniCartClose").unbind("click");
    $("#miniCartClose").click(function(b) {
        miniCartDirection("up");
        b.stopPropagation();
    });
    $("#miniCart").unbind("click");
    $("#miniCart").click(function(b) {
        b.stopPropagation();
    });
    $("body").click(function(b) {
        if ($("#miniCart").is(":visible")) {
            miniCartDirection("up");
        }
        if ($("#wishList").is(":visible")) {
            wishListDirection("up");
        }
    });
    $("#headerWishlist").unbind("click");
    $("#headerWishlist").click(function(b) {
        if ($("#wishList").is(":visible")) {
            wishListDirection("up");
            b.preventDefault();
            b.stopPropagation();
        } else {
            wishListDirection("down");
            b.preventDefault();
            b.stopPropagation();
        }
    });
    $("#wishListClose").unbind("click");
    $("#wishListClose").click(function(b) {
        wishListDirection("up");
        b.stopPropagation();
    });
    $("#wishList").unbind("click");
    $("#wishList").click(function(b) {
        b.stopPropagation();
    });
    if ($("input:submit, a, button", ".genericButton") != null && $("input:submit, a, button", ".genericButton").length > 0) {
        $("input:submit, a, button", ".genericButton").button();
    }
}
function renderErrors(v, b) {
    $("#couponapplied").hide();
    $(".unusedCouponIds").remove();
    $("#promocoderemoved").hide();
    if (v == "resetPasswordForm") {
        $("#" + v).find(".email_confirm").hide();
    }
    if (v == "yourOrderForm") {
        $(".cart-validate").empty().hide();
        $(".expiredCouponIds").hide();
        $(".unusedCouponIds").hide();
        $("#errorCVV").empty().hide();
    }
    v = "#" + v;
    var n = $(v).find("#addToBagproductId").val();
    $("#generalErrors").find("p").each(function() {
        if (!$(this).hasClass("general-error-msg")) {
            $(this).remove();
        } else {
            $(this).hide();
        }
    });
    $(".generalErrors").find("p").each(function() {
        if (!$(this).hasClass("general-error-msg")) {
            $(this).remove();
        } else {
            $(this).hide();
        }
    });
    $(v).find("[id$=Error]").text("");
    $(v).find(".field-missing-color").removeClass("field-missing-color");
    if (v == "#usegiftcardForm") {
        $(v).find(".gift-card-add-success").hide();
        $(".gift-card-add-error").hide();
    }
    if (v == "#reviewForm") {
        $("#reviewForm #placeOrder").removeAttr("disabled");
    }
    if (v == "#giftCardForm") {
        $("#missingFields").empty();
        $("#giftCardAmtErr").empty();
    }
    if (v == "#editGiftCard") {
        $("#missingFields").empty();
        $("#giftCardAmtErr").empty();
    } else {
        if (v == "#addAllToBagForm") {
            $("#FavoriteMessageForAnony").empty().hide();
            $("#FavoriteMessage").empty().hide();
            $("#errorValidateBoxForAll").empty();
            $(".addallcart-validate").hide();
            $(".addallcart-error").empty();
            $(".addallcart-validate").empty();
        }
    }
    for (i = 0; i < b.length; i++) {
        var l = b[i].message;
        if (b[i].propertyName == "restrictShippingProperty" && v == "#shippingForm") {
            var o = "/checkout/includes/display_restricted_product.jsp?fromCheckout=true";
            var h = $("#shippingForm #shippingMethod").val();
            var u = $("#shippingForm #selectedAddress").val();
            var c = $("#shippingForm #state").val();
            var k = $("#shippingForm #selectedAddressState").val();
            var e = "";
            if (u != undefined && u != "new") {
                e = k;
            } else {
                e = c;
            }
            var j = "";
            if (h.indexOf("::") != -1) {
                var r = h.split("::");
                j = r[0].split(" ").join("");
            } else {
                j = h.trim();
            }
            o = o + "&state=" + e;
            o = o + "&shippingMethod=" + j;
            $("#restrictShipping").load(contextRoot + o,
            function(w) {
                handleRestrictedModal();
            });
        } else {
            if (b[i].propertyName == "restrictShippingProperty" && v == "#expressOrderForm") {
                location.href = "/checkout/shop_cart.jsp";
            } else {
                if (v == "#usegiftcardForm" && b[i].propertyName.length < 1) {
                    $(".gift-card-add-error span").empty().append(l);
                    $(".gift-card-add-error").show();
                } else {
                    if (v == "#expressOrderForm") {
                        var g = "#" + b[i].propertyName;
                        var l = b[i].message;
                        if (g == "#cvv") {
                            $("#securityCodeLabel").addClass("field-missing-color");
                            $(v).find(g).addClass("field-missing-color");
                            $(".cart-error").show();
                            $("#errorCVV").html("<p>" + l + "</p>");
                        } else {
                            $("#cartContainer #errorValidateBox").empty();
                            $("#cartContainer #errorValidateBox").css("border-bottom", "0px");
                            $("#cartContainer #errorValidateBox").css("border-top", "0px");
                            $(".cart-error").show();
                            $("#errorCVV").html("<p>" + l + "</p>");
                        }
                    } else {
                        if (v == "#updateCart") {
                            $(".quantity-missing-text").empty().append(l);
                        } else {
                            if (v == "#addAllToBagForm") {
                                $(".addallcart-error").append(l);
                                $(".addallcart-error").show();
                            } else {
                                if (v == "#editGiftCard") {
                                    if (b[i].propertyName == "giftCardAmount") {
                                        $("#missingFields").empty();
                                        $("#missingFields").append(l);
                                        $("#missingFields").show();
                                        continue;
                                    }
                                    if (b[i].propertyName == "giftCardLimit") {
                                        $("#giftCardAmtErr").empty();
                                        $("#giftCardAmtErr").append(l);
                                        $("#giftCardAmtErr").show();
                                        continue;
                                    } else {
                                        $("#missingFields").append(l);
                                        $("#missingFields").show();
                                    }
                                } else {
                                    if (v == "#giftCardForm") {
                                        if (b[i].propertyName == "giftCardAmount") {
                                            $("#missingFields").empty();
                                            $("#missingFields").append(l);
                                            $("#missingFields").show();
                                            continue;
                                        }
                                        if (b[i].propertyName == "giftCardLimit") {
                                            $("#giftCardAmtErr").empty();
                                            $("#giftCardAmtErr").append(l);
                                            $("#giftCardAmtErr").show();
                                            continue;
                                        } else {
                                            $("#missingFields").empty();
                                            $("#missingFields").append(l);
                                            $("#missingFields").show();
                                        }
                                    } else {
                                        if (v == "#addtocart_" + n) {
                                            $(".addToCart_GeneralErrors").empty();
                                            $(".addToCart_GeneralErrors").append(l);
                                            $(".addToCart_GeneralErrors").show();
                                        } else {
                                            if ((b[i].propertyName.indexOf("error") >= 0) || (b[i].propertyName.length < 1)) {
                                                $("#generalErrors").append("<p>" + l + "</p>");
                                                $("#generalErrors").addClass("field-missing-color");
                                                $(".generalErrors").append("<p>" + l + "</p>");
                                                $(".generalErrors").addClass("field-missing-color");
                                                if ((v == "#yourOrderForm" || $(".checkout-container.onePage").length == 1) && b[i].propertyName == "error1") {
                                                    $(v).find("input#globalError").addClass("field-missing-color");
                                                }
                                                $("html, body").animate({
                                                    scrollTop: $("#navContainer").offset().top
                                                },
                                                200);
                                                $('input[type="password"]').val("");
                                            } else {
                                                var p = "#" + b[i].propertyName;
                                                if (p == "#login") {
                                                    $(v).find("#submitMailingList").addClass("field-missing-color");
                                                } else {
                                                    if (p == "#storeLocatorAddressField") {
                                                        $(v).find("#StoreFinderSearchBtn").addClass("field-missing-color");
                                                    }
                                                }
                                                var t = p + "Label";
                                                var m = p + "Error";
                                                $(v).find(p).addClass("field-missing-color");
                                                $(v).find(t).addClass("field-missing-color");
                                                $(v).find(m).addClass("field-missing-color");
                                                $(v).find(m).append("<p>" + l + "</p>");
                                                if (v == "#eGiftCardDetails") {
                                                    $(".field-missing-color").each(function() {
                                                        var w = $(this).attr("for");
                                                        $("#" + w).addClass("field-missing-color");
                                                    });
                                                }
                                                if (v == "#accountCreation") {
                                                    if (t == "#termsAndConditionsLabel") {
                                                        if ($("#termsAndConditionsLabel").hasClass("field-missing-color")) {
                                                            $("#termsAndConditionsLabel").find("a").addClass("field-missing-color");
                                                        }
                                                    }
                                                }
                                                if (!$(v).hasClass("modalForm") && ($(p).length != 0)) {
                                                    $("#generalErrors").addClass("field-missing-color").find("p.general-error-msg").show();
                                                    $(".generalErrors").addClass("field-missing-color").find("p.general-error-msg").show();
                                                }
                                                $('input[type="password"]').val("");
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    var d = "";
    for (i = 0; i < b.length; i++) {
        var f = b[i].message;
        d = d + f + ":";
    }
    s.prop9 = d;
    var q = s.t();
    if (q) {
        document.write(q);
    }
    if (p) {
        $("#" + b[0].propertyName).focus();
    }
    formPlaceholderFix();
}
function GetCardType(c) {
    var b = new RegExp("^4");
    if (c.match(b) != null) {
        return "visa";
    }
    b = new RegExp("^(34|37)");
    if (c.match(b) != null) {
        return "americanExpress";
    }
    b = new RegExp("^5[1-5]");
    if (c.match(b) != null) {
        return "masterCard";
    }
    b = new RegExp("^6[0|22|4|5]");
    if (c.match(b) != null) {
        return "discover";
    }
    return null;
}
function checkStrength(b) {
    var c = 0;
    if (b.length < 6) {
        $("#meterLevel1, #meterLevel2, #meterLevel3").removeClass();
        $("#meterLevel1, #meterLevel2, #meterLevel3").addClass("password-short");
        return "Too short";
    }
    if (b.length > 7) {
        c += 1;
    }
    if (b.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
        c += 1;
    }
    if (b.match(/([a-zA-Z])/) && b.match(/([0-9])/)) {
        c += 1;
    }
    if (b.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
        c += 1;
    }
    if (b.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,",%,&,@,#,$,^,*,?,_,~])/)) {
        c += 1;
    }
    if (c < 2) {
        $("#meterLevel1, #meterLevel2, #meterLevel3").removeClass();
        $("#meterLevel1").addClass("password-weak");
        $("#meterLevel2, #meterLevel3").addClass("password-short");
        return "Weak";
    } else {
        if (c == 2) {
            $("#meterLevel1, #meterLevel2, #meterLevel3").removeClass();
            $("#meterLevel1, #meterLevel2").addClass("password-medium");
            $("#meterLevel3").addClass("password-short");
            return "Medium";
        } else {
            $("#meterLevel1, #meterLevel2, #meterLevel3").removeClass();
            $("#meterLevel1, #meterLevel2, #meterLevel3").addClass("password-strong");
            return "Strong";
        }
    }
}
function toolTip(b, e, c, d) {
    $("#headerLang").click(function(f) {
        $("#languageSelect").toggle("fade", 200);
        f.stopPropagation();
        closeMiniCart();
    });
    if ($(b) != null && $(b).length > 0) {
        $(b).tooltip({
            position: {
                my: e,
                at: c
            },
            tooltipClass: d,
            collision: "none"
        });
    }
}
function dropDownOffset() {
    var j, B, e, D, p, z, E, A, C, o = 0,
    u = 0;
    $("#footer_menu, .dept-dd").css("display", "block");
    B = $("#footer_menu .dept-dd");
    de = $(".nav-name");
    e = $("ul#navList .nav-item");
    var c = 0;
    for (var y = e.length - 1; y >= 0; y--) {
        c += e[y].offsetWidth;
    }
    $("#navMenu").css("width", c);
    if ($(window).width() >= 1024) {
        var b = $(window).width();
        $("#navMenu").css("max-width", b + "px");
    } else {
        $("#navMenu").css("max-width", "1024px");
    }
    if (c <= 960) {
        $("#footer_menu .dept-dd").css("max-width", "960px");
    } else {
        $("#footer_menu .dept-dd").css("max-width", c - 14);
    }
    $("#footer_menu .dept-dd.DK-menu").css("max-width", $(window).width() - 2 + "px");
    for (var y = 0; y < B.length; y++) {
        $("#footer_menu, .dept-dd").css("display", "block");
        var g = $(B[y]).find("ul.menuUL").length;
        initSlider($(B[y]), g);
        p = 0;
        j = $(B[y]).parent().parent().offset();
        for (var v = 0; v < $(B[y]).find("ul.menuUL").length; v++) {
            p += $(B[y]).find("ul.menuUL").eq(v).width() + 20;
        }
        if ($(B[y]).find("div").hasClass("spotlight-slider")) {
            p += $(B[y]).find(".spotlight-slider").width() + 65;
        } else {
            if ($(B[y]).hasClass("DK-menu")) {
                p += -30;
            } else {
                $(B[y]).find("ul.menuUL:last").css("border", "none");
            }
        }
        p += 15;
        $(B[y]).css("width", p);
        ddOffsetLeft = $(de[y]).parent(".nav-item").width() + 44;
        o = o + ddOffsetLeft;
        if (($(de[y]).parent(".nav-item").offset().left - $(de[y]).parents("#navList").offset().left) < 10) {
            D = $(de[y]).parent(".nav-item").offset().left;
        } else {
            D = $(de[y]).parent(".nav-item").offset().left - $(de[y]).parents("#navList").offset().left;
        }
        z = (p - ddOffsetLeft) / 2;
        var t = $(de[y]).parent(".nav-item").outerWidth();
        var h = $(de[y]).parent(".nav-item").position().left;
        var f = (h) + (t / 2);
        var d = t + h;
        var r = h - (t + (t / 2));
        var q = parseInt(ddOffsetLeft / 2) - 2;
        if (p > 480) {
            if (p < d) {
                var n = $(de[0]).parent(".nav-item").offset().left;
                if ($(B[y]).hasClass("DK-menu")) {
                    $(B[y]).children().css("margin-left", $(de[0]).parent(".nav-item").offset().left + "px");
                } else {
                    $(B[y]).css("left", ((t * 2) + n) + "px");
                    $("#" + $(B[y]).attr("id") + " .arrow").css("left", r + "px");
                }
            } else {
                if ($(B[y]).hasClass("DK-menu")) {
                    $(B[y]).children().css("margin-left", $(de[0]).parent(".nav-item").offset().left + "px");
                } else {
                    $(B[y]).css("left", $(de[0]).parent(".nav-item").offset().left + "px");
                }
                $("#" + $(B[y]).attr("id") + " .arrow").css("left", f + "px");
            }
        } else {
            $(B[y]).css("left", $(de[y]).parent(".nav-item").offset().left + "px");
            $("#" + $(B[y]).attr("id") + " .arrow").css("left", t / 2 + "px");
        }
        E = ($("#navList").find("#displaySearch").offset().left + 44) - $(".nav-item").offset().left - ddOffsetLeft;
        if (z > E) {
            A = z - E;
            C = z + A;
            $(B[y]).css("left", C + "px");
        }
    }
}
$("#headerLang").click(function(b) {
    $("#languageSelect").toggle("fade", 200);
    b.stopPropagation();
    closeLangSelect();
});
$("#headerLang,#headerContactIcons").hover(function() {
    $("#signInBox,#signInArrow,#miniCartContiainer,#myAccountBox").hide();
    mouse_is_inside = true;
});
$("#headerLang,#headerContactIcons").mouseover(function(b) {
    $("#languageSelect").addClass("hoverActive");
    $("#languageSelect").show("fade", 200);
    $("#signInBox,#signInArrow,#miniCartContiainer,#myAccountBox").hide();
});
$("#headerLang,#headerContactIcons").mouseleave(function(b) {
    $("#languageSelect").removeClass("hoverActive");
    setTimeout(function() {
        if (!$("#languageSelect").hasClass("overActive")) {
            $("#languageSelect").hide();
        }
    },
    500);
});
$("#languageSelect").mouseover(function(b) {
    $("#languageSelect").addClass("overActive");
});
$("#languageSelect").mouseleave(function(b) {
    $("#languageSelect").hide("fade", 200);
    $("#languageSelect").removeClass("overActive");
});
$("#headerContactIcons").mouseover(function(b) {
    var c = $("#headerContactIcons").offset();
    $("#languageSelect").css({
        top: c.down,
        left: c.left - 75
    });
});
function closeLangSelect() {
    $("#languageSelect, #headerLang").hover(function() {
        mouse_is_inside = true;
    },
    function() {
        mouse_is_inside = false;
    });
    $("body").mouseup(function() {
        if (!mouse_is_inside) {
            $("#languageSelect").hide("fade", 200);
        }
    });
    $(document).on("keyup",
    function(b) {
        if (b.keyCode === 27) {
            $("#languageSelect").hide("fade", 200);
        }
    });
}
function buildUrl(g) {
    var c = $("input[name=Dy]").val();
    var b = $("input[name=Nty]").val();
    var f = $("input[name=Ntt]").val();
    var d = $("select[name=N]");
    var h = $("select[name=N] option:selected").val();
    var e = encodeURIComponent(f).replace(/%20/g, "+");
    if (h > "") {
        location.href = "/search" + h + "/Ntt-" + e;
    } else {
        location.href = "/endeca_search/index.jsp?N=0&Ntt=" + e + "&Dy=" + c + "&Nty=" + b;
    }
    if (/Chrome[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {}
    return false;
}
function CheckFB(b, e) {
    var g;
    var d = $("input#trackingPageName").val();
    var h = $("input#plp").val();
    var f = $("input#quickview").val();
    if (d == "Product Detail") {
        g = $("div#productDetailsPageContainer input#iprosProdPriceval").val();
        if ($("div#productDetailsPageContainer div#productPrice strike div.display_price input#iprosProdPriceval").length) {
            g = $("div#productDetailsPageContainer div#productPrice div.pricerangecolor input#iprosProdPriceval").val();
        } else {
            g = $("div#productDetailsPageContainer div#productPrice div.display_price input#iprosProdPriceval").val();
        }
    } else {
        if (d == "browse" && h == "small") {
            g = getPriceSmall(e);
        } else {
            if (d == "browse" && h == "medium") {
                g = getPriceMedium(e);
            } else {
                if (d == "browse" && h == "large") {
                    g = getPriceLarge(e);
                } else {
                    if (d == "Outfit Detail") {
                        if ($("div#outfitItem_" + e + " h5.outfit-item-product-price strike div input#iprosProdPriceval").length) {
                            g = $("div#outfitItem_" + e + " h5.outfit-item-product-price div.PriceRed input#iprosProdPriceval").val();
                        } else {
                            g = $("div#outfitItem_" + e + " h5.outfit-item-product-price div.display_price input#iprosProdPriceval").val();
                        }
                    } else {
                        if (d == "Shopping Cart") {
                            g = $("table#cartContents tbody tr#" + e + " td.detailsItem input#cartTrackingPrice ").val();
                        } else {
                            if (f == "quickview") {
                                if ($("div#productQuickviewModal div#detailsBox div.strike_price strike input#iprosProdPriceval").length) {
                                    g = $("div#productQuickviewModal div#detailsBox div.PriceRed input#iprosProdPriceval").val();
                                } else {
                                    g = $("div#productQuickviewModal div#detailsBox div.display_price input#iprosProdPriceval").val();
                                }
                            } else {
                                if (d == "" && h == "small") {
                                    g = getPriceSmall(e);
                                } else {
                                    if (d == "" && h == "medium") {
                                        g = getPriceMedium(e);
                                    } else {
                                        if (d == "" && h == "large") {
                                            g = getPriceLarge(e);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    var c = "/includes/common_ajax.jsp?pageNameValue=" + b + "&productPrice=" + g + "&eventName=favorites";
    jQuery.ajax({
        url: c,
        type: "GET",
        dataType: "html",
        success: function(n) {
            $("#dummyDiv").html(n);
            var l = $("input#ajaxpixelId").val();
            var k = $("input#ajaxcurrencyType").val();
            var o = $("input#ajaxcartValue").val();
            var j = $("input#ajaxuserLocale").val();
            var m = $("div#socialPixelImageDiv").html();
            $("body #socialpixel").html(m);
            $("div#socialPixelImageDiv").empty();
            facebookPixelInclude(l, k, o, j);
        },
        error: function(l, j, k) {}
    });
}
function getPriceSmall(b) {
    if ($("li#" + b + " div.display_price strike input#iprosProdPriceval").length) {
        price = $("li#" + b + " div.pricerangecolor input#iprosProdPriceval").val();
        return price;
    } else {
        price = $("li#" + b + " div.display_price input#iprosProdPriceval").val();
        return price;
    }
}
function getPriceMedium(b) {
    if ($("li#product_" + b + " h4 strike div.display_price input#iprosProdPriceval").length) {
        price = $("li#product_" + b + " h4 div.pricerangecolor input#iprosProdPriceval").val();
        return price;
    } else {
        price = $("li#product_" + b + " h4 div.display_price input#iprosProdPriceval").val();
        return price;
    }
}
function getPriceLarge(b) {
    if ($("li#" + b + " div.strike_price strike input#iprosProdPriceval").length) {
        price = $("li#" + b + " div.PriceRed input#iprosProdPriceval").val();
        return price;
    } else {
        price = $("li#" + b + " div.display_price input#iprosProdPriceval").val();
        return price;
    }
}
function addToFavorite(c, g, b, f, e) {
    var d = c;
    $("#FavoriteMessageForAnony").empty();
    $("#FavoriteMessageForAnony").hide();
    $("#qtyUpdatesuccessmsg").empty().hide();
    $("#errorValidateBoxForAll").empty();
    $(".addallcart-validate").empty().hide();
    $(".addallcart-error").empty().hide();
    productadding = true;
    $.ajax({
        url: "/category/includes/ajax_add_item_to_favorite.jsp?productId=" + c + "&catalogRefID=" + g + "&quickViewPage=" + e,
        success: function(l) {
            $("." + b).replaceWith(l);
            var k = $("#favouriteProductName_" + c + "_" + g).val();
            var j = $("#favoriteProductMessage1").val();
            var h = $("#favoriteProductMessage2").val();
            productadding = false;
            if ($(".ui-dialog").is(":visible")) {
                $(".FavoriteMessage_qv").empty();
                $(".FavoriteMessage_qv").append(j + " " + k + " " + h);
                $(".FavoriteMessage_qv").show();
            } else {
                $("#FavoriteMessage").empty();
                $("#FavoriteMessage").append(j + " " + k + " " + h);
                $("#FavoriteMessage").show();
            }
        },
        error: function(k, h, j) {
            console.log(k, h, j);
            if (k.status == "409") {
                location.href = sessionexpurl;
            } else {
                location.href = internalServerError;
            }
        }
    });
}
function removeFromFavorite(d, b, e, h, c, g, f) {
    $("#FavoriteMessageForAnony").empty();
    $("#FavoriteMessageForAnony").hide();
    $("#qtyUpdatesuccessmsg").empty().hide();
    $("#errorValidateBoxForAll").empty();
    $(".addallcart-validate").empty().hide();
    $(".addallcart-error").empty().hide();
    productadding = true;
    $.ajax({
        url: "/category/includes/ajax_remove_items_favorite.jsp?giftListId=" + d + "&giftItemId=" + b + "&productId=" + e + "&catalogRefID=" + h + "&quickViewPage=" + f,
        success: function(m) {
            $("." + c).replaceWith(m);
            productadding = false;
            var l = $("#favouriteProductName_" + e + "_" + h).val();
            var k = $("#favoriteProductMessage1").val();
            var j = $("#favoriteProductMessage3").val();
            if ($(".ui-dialog").is(":visible")) {
                $(".FavoriteMessage_qv").empty();
                $(".FavoriteMessage_qv").append(k + " " + l + " " + j);
                $(".FavoriteMessage_qv").show();
            } else {
                $("#FavoriteMessage").empty();
                $("#FavoriteMessage").append(k + " " + l + " " + j);
                $("#FavoriteMessage").show();
            }
            $(".unfavorite-heart").addClass("unFav");
        },
        error: function(l, j, k) {
            console.log(l, j, k);
            if (l.status == "409") {
                location.href = sessionexpurl;
            } else {
                location.href = internalServerError;
            }
        }
    });
}
function addToFavorite_article(d, g, e, f, b, c) {
    var g = $("div#nofavorites_" + d + " input#articleDescription").val();
    var e = $("div#nofavorites_" + d + " input#category").val();
    var f = $("div#nofavorites_" + d + " input#title").val();
    var b = $("div#nofavorites_" + d + " input#imgURL").val();
    var c = $("div#nofavorites_" + d + " input#linkURL").val();
    $("#FavoriteMessageForAnony").empty();
    $("#FavoriteMessageForAnony").hide();
    $("#qtyUpdatesuccessmsg").empty().hide();
    $("#errorValidateBoxForAll").empty();
    $(".addallcart-validate").empty().hide();
    $(".addallcart-error").empty().hide();
    productadding = true;
    $.ajax({
        url: "/cartridges/article/ajax_add_item_article.jsp",
        data: {
            articleId: d,
            articleDescription: g,
            category: e,
            title: f,
            imgURL: b,
            linkURL: c
        },
        success: function(k) {
            $(".nofavorites_" + d).replaceWith(k);
            var l = $("#favouriteArticleName_" + d).val();
            var j = $("#favoriteArticleMessage1").val();
            var h = $("#favoriteArticleMessage2").val();
            $("#ArticleMessage").empty();
            productadding = false;
            $("#ArticleMessage").append(j + " " + l + " " + h);
            $("#ArticleMessage").show();
        },
        error: function(k, h, j) {
            console.log(k, h, j);
            if (k.status == "409") {
                location.href = sessionexpurl;
            } else {
                location.href = internalServerError;
            }
        }
    });
}
function removeFromFavorite_article(d, g, e, f, b, c) {
    var g = $("div#favorites_" + d + " input#articleDescription").val();
    var e = $("div#favorites_" + d + " input#category").val();
    var f = $("div#favorites_" + d + " input#title").val();
    var b = $("div#favorites_" + d + " input#imgURL").val();
    var c = $("div#favorites_" + d + " input#linkURL").val();
    $("#FavoriteMessageForAnony").empty();
    $("#FavoriteMessageForAnony").hide();
    $("#qtyUpdatesuccessmsg").empty().hide();
    $("#errorValidateBoxForAll").empty();
    $(".addallcart-validate").empty().hide();
    $(".addallcart-error").empty().hide();
    productadding = true;
    $.ajax({
        url: "/cartridges/article/ajax_remove_item_article.jsp",
        data: {
            articleId: d,
            articleDescription: g,
            category: e,
            title: f,
            imgURL: b,
            linkURL: c
        },
        success: function(j) {
            $(".favorites_" + d).replaceWith(j);
            var l = $("#favouriteArticleName_" + d).val();
            var h = $("#favoriteArticleMessage1").val();
            var k = $("#favoriteArticleMessage3").val();
            $("#ArticleMessage").empty();
            productadding = false;
            $("#ArticleMessage").append(h + " " + l + " " + k);
            $("#ArticleMessage").show();
        },
        error: function(k, h, j) {
            console.log(k, h, j);
            if (k.status == "409") {
                location.href = sessionexpurl;
            } else {
                location.href = internalServerError;
            }
        }
    });
}
function enableSaveCardButton() {
    $("#saveCreditCard").attr("disabled", false);
}
$("#swatch-outline").click(function(b) {
    location.href = $("div#swatch-outline").children("a").attr("href");
});
$("#showSubNav").click(function(b) {
    b.preventDefault();
    $("#selectedViewFormDown").hide();
    $("#selectedViewFormUp").show();
    $("#collapseSubNav").css("display", "block");
    $("#footerNavMenu ul li span").css("cursor", "default");
    $("#footerNavMenu ul li ul span").css("cursor", "pointer");
    $("#footerNavMenu ul li ul.socialul li:first span").css("cursor", "default");
    $("#footerNavMenu ul li ul").css("display", "block");
    $("#footerNavMenu ul li .closeSocialLinks ul").css("display", "none");
    $(".copyright_txt").css("display", "block");
    $("#showSubNav").css("display", "none");
    $("html,body").animate({
        scrollTop: $(document).height()
    },
    100);
});
$("#footerNavMenu ul li").find("a").click(function(b) {});
$("#collapseSubNav").click(function(b) {
    b.preventDefault();
    $("#selectedViewFormDown").show();
    $("#selectedViewFormUp").hide();
    $("#collapseSubNav").css("display", "none");
    $("#footerNavMenu ul li").find("a").css("cursor", "pointer");
    $("#footerNavMenu ul li ul").css("display", "none");
    $("#footerNavMenu ul li .closeSocialLinks ul").css("display", "block");
    $(".copyright_txt").css("display", "none");
    $("#showSubNav").css("display", "block");
});
$(window).load(function() {
    var b = $("#selectedView").val();
    if (b == "true") {
        $("#selectedViewFormDown").show();
        $("#selectedViewFormUp").hide();
        $("#collapseSubNav").css("display", "none");
        $("#footerNavMenu ul li span").css("cursor", "pointer");
        $("#footerNavMenu ul li ul").css("display", "none");
        $("#footerNavMenu ul li .closeSocialLinks ul").css("display", "block");
        $(".copyright_txt").css("display", "none");
        $("#showSubNav").css("display", "block");
    } else {
        $("#selectedViewFormDown").hide();
        $("#selectedViewFormUp").show();
        $("#collapseSubNav").css("display", "block");
        $("#footerNavMenu ul li span").css("cursor", "default");
        $("#footerNavMenu ul li ul span").css("cursor", "pointer");
        $("#footerNavMenu ul li ul.socialul li:first span").css("cursor", "default");
        $("#footerNavMenu ul li ul").css("display", "block");
        $("#footerNavMenu ul li .closeSocialLinks ul").css("display", "none");
        $(".copyright_txt").css("display", "block");
        $("#showSubNav").css("display", "none");
    }
});
function imageExists(c, d) {
    var b = new Image();
    b.onload = function() {
        d(true);
    };
    b.onerror = function() {
        d(false);
    };
    b.src = c;
}
$(document).on("click", ".removeFromBag",
function(b) {
    b.preventDefault();
    noajaxloader = false;
    productadding = true;
    jQuery.ajax({
        url: jQuery(this).attr("href"),
        type: "post",
        dataType: "json",
        success: function(c) {
            noajaxloader = false;
            if ("failure" == c.result) {
                location.href = shoppingBagLink + "?status=removefailure";
            } else {
                noajaxloader = false;
                jQuery.ajax({
                    url: "/checkout/includes/order_item_count.jsp",
                    type: "POST",
                    dataType: "html",
                    success: function(d) {
                        noajaxloader = false;
                        $("#orderitemcount").replaceWith(d);
                        $("#itemsInCartNotifier").html("<div class='itemsInCartNotifier_span'>" + d + "</div>");
                        $("#headerSignIn #orderitemcount").css("display", "none");
                        $("#headerAccountLink #orderitemcount").css("display", "none");
                    }
                });
                noajaxloader = false;
                jQuery.ajax({
                    url: "/includes/miniBagDetail.jsp?isRepriceRequired=true",
                    type: "POST",
                    dataType: "html",
                    success: function(d) {
                        noajaxloader = false;
                        $("#miniCartContiainer").html(d).show();
                        if ($("#miniCartItems_scroll").height() > 200) {
                            $("#miniCartItems_scroll").jScrollPane();
                        }
                        setTimeout(function() {
                            $("#miniCartContiainer").hide();
                        },
                        3000);
                    }
                });
                noajaxloader = false;
                jQuery.ajax({
                    url: "/checkout/includes/shop_cart_include.jsp",
                    type: "POST",
                    dataType: "html",
                    success: function(d) {
                        noajaxloader = false;
                        $("#cartContainer").replaceWith(d);
                        $("select").selectbox();
                        $("#content_1").jScrollPane();
                        $("#removesuccess").show();
                        jQuery.post(contextRoot + "/checkout/includes/update_ship_method.jsp", {
                            shipMethod: jQuery("#shippingMethod").val()
                        },
                        function(f) {
                            jQuery.ajax({
                                url: contextRoot + "/checkout/includes/display_order_total.jsp",
                                type: "get",
                                cache: false,
                                success: function(g) {
                                    jQuery(".order-total-line").html(g);
                                }
                            });
                        });
                        var e = $("div.emptyCartSlotContent").children().attr("src");
                        if (e == "" || e == undefined) {
                            $("div.emptyCartSlotContent").hide();
                        } else {
                            $("div#yourOrderContainer").show();
                        }
                        SetTabIndexForcheckOut();
                    }
                });
            }
        },
        error: function(e, c, d) {
            if (e.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
});
$(document).on("click", ".PopupremoveFromBag",
function(d) {
    d.preventDefault();
    var c = $(this).attr("rel") - 1;
    var b = $("#RestrictedProductUrl").val();
    noajaxloader = false;
    jQuery.ajax({
        url: jQuery(this).attr("href"),
        type: "post",
        dataType: "json",
        success: function(e) {
            noajaxloader = false;
            if ("failure" == e.result) {
                location.href = shoppingBagLink + "?status=removefailure";
            } else {
                noajaxloader = false;
                jQuery.ajax({
                    url: "/includes/miniBagDetail.jsp",
                    type: "POST",
                    dataType: "html",
                    success: function(f) {
                        $("#miniCartContiainer").html(f);
                        noajaxloader = false;
                    }
                });
                noajaxloader = false;
                jQuery.ajax({
                    url: "/checkout/includes/order_item_count.jsp",
                    type: "POST",
                    dataType: "html",
                    success: function(f) {
                        noajaxloader = false;
                        $("#orderitemcount").replaceWith(f);
                        $("#itemsInCartNotifier").html("<div class='itemsInCartNotifier_span'>" + f + "</div>");
                        $("#headerSignIn #orderitemcount").css("display", "none");
                        $("#headerAccountLink #orderitemcount").css("display", "none");
                    }
                });
                noajaxloader = false;
                jQuery.ajax({
                    url: "/checkout/includes/shop_cart_include.jsp",
                    type: "POST",
                    dataType: "html",
                    success: function(f) {
                        $("#cartContainer").replaceWith(f);
                        noajaxloader = false;
                        $("select").selectbox();
                        $("#content_1").jScrollPane();
                        SetTabIndexForcheckOut();
                    }
                });
                if (c == 0 || c < 1) {
                    $("#CartModel-output").dialog("close");
                } else {
                    noajaxloader = false;
                    jQuery.ajax({
                        url: "includes/display_restricted_product.jsp",
                        dataType: "html",
                        success: function(f) {
                            noajaxloader = false;
                            $("#CartModel-output").html("");
                            $("#CartModel-output").html(f);
                        }
                    });
                }
            }
        }
    });
});
function CartDialog(e) {
    showSignInModal = $(document).getUrlParam("showSignInModal");
    if (!showSignInModal) {
        var d = parseInt($("#anonymous").val());
        var b = parseInt($("#logInSecurityCode").val());
        showSignin = $(document).getUrlParam("showSignin");
        if (! (showSignin && d < b)) {
            var c = $("<div id='CartModel-output'></div>");
            $("body").append(c);
            c.load(e, null,
            function() {
                c.dialog({
                    modal: true,
                    autoOpen: true,
                    closeOnEscape: true,
                    closeText: "Close Window",
                    dialogClass: "no-close",
                    draggable: false,
                    resizable: false,
                    position: ["center", 100],
                    width: "auto",
                    height: "auto",
                    show: {
                        effect: "fade",
                        duration: 300
                    },
                    hide: {
                        effect: "fade",
                        duration: 300
                    },
                    close: function(f, g) {
                        $(this).dialog("destroy").remove();
                    }
                });
                ShopcartTooltip(".Shopcarttooltip");
            });
        }
    }
}
function ShopcartTooltip(b) {
    $(b).tooltipster({
        animation: "fade",
        theme: ".my-custom-theme",
        delay: 100,
        trigger: "hover",
    });
}
$(document).on("click", ".additemBag",
function(b) {
    b.preventDefault();
    productadding = false;
    productVar = $(b.currentTarget);
    noajaxloader = true;
    jQuery.ajax({
        url: jQuery(this).attr("href"),
        type: "post",
        dataType: "json",
        success: function(e) {
            if (e.result == "success") {
                commonAjaxCall("addToCart", "AddToCartEventPage", "isRepriceRequired");
                if (e.addedfromcart == "true") {
                    window.location = contextRoot + "/checkout/shop_cart.jsp";
                } else {
                    jQuery.ajax({
                        url: "/checkout/includes/shop_cart_include.jsp",
                        type: "POST",
                        dataType: "html",
                        success: function(f) {
                            $("#cartContainer").replaceWith(f);
                            $("select").selectbox();
                            $("#content_1").jScrollPane();
                            SetTabIndexForcheckOut();
                        }
                    });
                    $("#miniCartContiainer").show().delay(300).hide();
                    var c = $("#miniCartContiainer");
                    c.show();
                    setTimeout(function() {
                        c.hide();
                    },
                    3000);
                    return false;
                }
            }
            if (e.result == "error") {
                $("#FavoriteMessageForAnony").empty().hide();
                $("#errorValidateBox").empty().hide();
                $(".cart-validate").empty().hide();
                $("#FavoriteMessage").empty().hide();
                $("#errorValidateBoxForAll").empty();
                $(".addallcart-validate").hide();
                $(".addallcart-error").empty();
                $(".addallcart-validate").empty();
                for (i = 0; i < e.errors.length; i++) {
                    var d = e.errors[i].message;
                    $(".addallcart-error").append(d);
                }
                $(".addallcart-error").show();
            }
        }
    });
});
$("form#resetPasswordForm #securityQuestion").on("change",
function() {
    var b = $("#securityQuestion option:selected").val();
    if (b != "") {
        $("form#resetPasswordForm").find("#submit").removeAttr("disabled");
    }
    if (b == "") {
        $("form#resetPasswordForm").find("#submit").attr("disabled", true);
    }
});
var x = $("#anonyFavForFacebook").val();
if (x) {
    var productId = $("input#anonProductId").val();
    CheckFB("favorites", productId);
}
$(document).ready(function() {
    $(".article_favorite").on("click",
    function(b) {
        b.preventDefault();
        $this = $(this);
        $this.parents(".favorite-actions").find("form#articlefavorites").trigger("submit");
    });
});
function sessionExpired() {
    showSignInModal = $(document).getUrlParam("showSignInModal");
    if (showSignInModal) {
        var b = $('<div id="SigninModal_new"></div>').load(contextRoot + "/modals/soft_login_modal.jsp?navigateToCart=true").dialog({
            modal: true,
            of: window,
            autoOpen: false,
            closeOnEscape: true,
            closeText: "Close Window",
            dialogClass: "no-close",
            draggable: false,
            resizable: false,
            width: 340,
            show: {
                effect: "fade",
                duration: 300
            },
            hide: {
                effect: "fade",
                duration: 300
            },
            open: function(c, d) {
                setTimeout(function() {
                    $(".softlogin").attr("readonly", "readonly");
                },
                100);
            }
        });
        b.dialog("open");
        return false;
    }
}
$(document).on("click", ".newwindowanchor",
function() {
    var b = $(location).attr("hostname");
    if ($.browser.msie && $.browser.version == 9) {
        window.open("/stores/includes/newsletter_details.jsp", "_blank", "toolbar=no, location=no, directories=no, status=no, menubar=1, scrollbars=yes, resizable=no, copyhistory=no, width=504,height=164");
        return false;
    } else {
        window.open("/stores/includes/newsletter_details.jsp", "News_Letter", "menubar=1,resizable=1,width=504,height=164");
        return false;
    }
});
$(document).ready(function() {
    if ($.browser.msie && $.browser.version == 9) {
        $("ul#navList li").on("hover",
        function() {
            var c = $("#searchText");
            var b = c.val();
            if (c.val() == b) {
                $("#searchText").blur();
            }
        });
    }
});
function headerMyAccClick() {
    $("#signInBoxEmail").val("");
    document.getElementById("passwordError").innerHTML = "";
    document.getElementById("loginError").innerHTML = "";
    $("#signInBoxPassword").val("");
}
function logout(c, e, d, b) {
    $("#locale").val(b);
    if (c != e) {
        $("#dialog-confirm p").css("display", "block");
        $("#dialog-confirm").dialog({
            resizable: false,
            modal: true,
            buttons: {
                Yes: function() {
                    $("#switchCountry").val("yes");
                    if (b == "fr_CA") {
                        $("#switchURL").val("http://" + d + "/?language=" + b);
                    } else {
                        $("#switchURL").val("http://" + d);
                    }
                    $("#set_locale_to_profile").submit();
                },
                No: function() {
                    $(this).dialog("close");
                }
            },
            open: function() {
                $(".ui-dialog").removeAttr("tabindex");
                $(".ui-button").each(function() {
                    if ($(this).find(".ui-button-text").text() == "Yes") {
                        $(this).attr("tabindex", "1");
                    } else {
                        if ($(this).find(".ui-button-text").text() == "No") {
                            $(this).attr("tabindex", "1");
                        }
                    }
                });
                $(".ui-button").focus(function() {
                    var f = $(this).find(".ui-button-text");
                    $("body").keydown(function(h) {
                        var g = h.keyCode || h.which;
                        if (g == 13) {
                            f.trigger("click");
                        }
                    });
                });
            }
        });
    } else {
        $("#switchCountry").val("no");
        if (b == "fr_CA") {
            $("#switchURL").val("http://" + d + "/?language=" + b);
        } else {
            $("#switchURL").val("http://" + d);
        }
        $("#set_locale_to_profile").submit();
    }
}
$(document).off("keyup change input paste", ".txtarea").on("keyup change input paste", ".txtarea",
function(f) {
    var d = $(this);
    var g = d.val();
    var b = g.length;
    var c = d.attr("maxlength");
    if (b > c) {
        d.val(d.val().substring(0, c));
    }
});
$(".ulcheckBoxFocus li,#termsContainer,#rememberContainer,.order_Remember").on("keypress",
function(b) {
    if (b.keyCode == 32) {
        if ($(this).find("label").hasClass("checked")) {
            $(this).find("label").removeClass("checked");
        } else {
            $(this).find("label").addClass("checked");
        }
        $(this).find(":checkbox").trigger("click");
        b.preventDefault();
    }
});
$(".ulDivBoxFocus li").on("keydown",
function(b) {
    if (b.keyCode == 32 || b.keyCode == 13) {
        $(this).find("div").trigger("click");
        b.preventDefault();
    }
});
$("input[name='completeAccount']").on("keydown",
function(c) {
    var b = $(this);
    if (c.keyCode == 13) {
        $("input[name='completeAccount']").trigger("click");
        c.preventDefault();
    }
});
$("#resetEmailSubmit,#orderstatus #submit,#facebookButton,#twitterButton").on("keydown",
function(b) {
    if (b.keyCode == 13) {
        $(this).trigger("click");
        b.preventDefault();
    }
});
$("#singin").find("#forgotPasswordDrop").on("keydown",
function(b) {
    if (b.keyCode == 13) {
        location.href = $(this).find("a").attr("href");
        b.preventDefault();
    }
});
$(".whats_thisContainer").on("keydown",
function(b) {
    if (b.keyCode == 13) {
        $(this).find("a").trigger("click");
        b.preventDefault();
    }
});
function SetTabIndexForcheckOut() {
    var c = 31;
    if ($("#cartTableContainer").length === 1) {
        var b = $("#cartTableContainer .unfavorite-heart,#cartTableContainer .cartName, #cartTableContainer .edit-product-link,#cartTableContainer .SelectQtyVal,#cartTableContainer .removeFromBag,#cartTableContainer .shipping_restriction_popup");
        $(b).each(function() {
            $(this).attr("tabindex", c);
            if ($(this).hasClass("SelectQtyVal")) {
                var d = $(this).attr("sb");
                var e = "#sbHolder_" + d;
                $(e).attr("tabindex", c);
            }
            c++;
        });
        $("#continueShoppingLink a").each(function() {
            $(this).attr("tabindex", c);
            c = c + 1;
        });
    }
    if ($("#yourOrderContainer").length === 1) {
        $("#yourOrderContainer #cvv").attr("tabindex", c);
        c++;
        $("#yourOrderContainer #CvvCodeToolTip a").attr("tabindex", c);
        c++;
        $("#yourOrderContainer .shipping_instruction_popup").attr("tabindex", c);
        c++;
        $("#yourOrderContainer #shippingMethod").attr("tabindex", c);
        $("#yourOrderContainer .sbHolder").attr("tabindex", c);
        c++;
        $("#yourOrderContainer #addCoupon").attr("tabindex", c);
        $("#yourOrderContainer #globalError").attr("tabindex", c);
        c++;
        $("#yourOrderContainer #claimCode").attr("tabindex", c);
        c++;
        $("#yourOrderContainer #standardCheckoutLink a").attr("tabindex", c);
        c++;
        $("#yourOrderContainer #cartCheckoutButton").attr("tabindex", c);
        c++;
        $("#yourOrderContainer #checkGiftCardBalaceLink").attr("tabindex", c);
        c++;
        $(".express-checkout-btn #cartCheckoutButton").attr("tabindex", c);
        c++;
        $("#yourOrderContainer .recommenedImages").attr("tabindex", c);
        $("#yourOrderContainer .add-to-bag-label-2 button").attr("tabindex", c);
        c++;
    }
}
function fillMyAccountBox() {
    var b = $("#headerAccountContainer");
    var d = 0;
    var c = b.children().length;
    if (c == 0) {
        jQuery.ajax({
            url: "/includes/header_account.jsp",
            type: "GET",
            dataType: "html",
            cache: false,
            success: function(e) {
                b.html(e);
                if (b.children("#signInBox").length) {
                    d = 1;
                }
                b.data("nonLoggedIn", d);
            },
            error: function(g, e, f) {}
        });
    }
    if (c == 0) {
        setTimeout(function() {
            enableMouseHoverEffect(b.data("nonLoggedIn"));
        },
        500);
    } else {
        enableMouseHoverEffect(b.data("nonLoggedIn"));
    }
}
function hideMyAccountDetails() {
    $("#myAccountBox").removeClass("overActive");
    setTimeout(function() {
        if (!$("#myAccountBox").hasClass("overActive")) {
            $("#myAccountBox").fadeOut(200);
            $(".sign-in-arrow").css("visibility", "visible");
        }
    },
    500);
}
function hideSignInDetails() {
    $("#signInBox").removeClass("hoverActive");
    setTimeout(function() {
        if (!$("#signInBox").hasClass("hoverActive")) {
            $("#signInBox,#signInArrow").css("visibility", "hidden");
            $(".sign-in-arrow").css("visibility", "visible");
            $("#signInBox,#signInArrow").hide("fade", 200);
            $("#signInBoxLeft input.css-checkbox").customInput();
        }
    },
    500);
}
function enableMouseHoverEffect(c) {
    if (c) {
        $("#signInBox").addClass("hoverActive");
        $("#largeOutfitCarousel").css("left", "-311px");
        if ($(".category-large-container ").hasClass("onlyOneProd")) {
            $(".lg-grid-prev").hide();
            $(".lg-grid-next").hide();
        }
        if (loadParentIframe === 0) {
            loadParentIframe = 1;
            $.getScript("/js/parentIframe.js",
            function(d, f, e) {});
        }
        $("#signInBox,#signInArrow").css("visibility", "visible");
        $(".sign-in-arrow").css("visibility", "visible");
        $("#signInBoxEmail").focus();
        $("#signInBox,#signInArrow").show("fade", 200);
        $("#miniCartContiainer,#languageSelect").hide();
        if ($(".category-large-container-Outfit").is(":visible")) {
            a.stopPropagation();
            if ($.browser.msie && $.browser.version == 9) {
                $("#largeOutfitCarousel").stop().css("left", "-459px");
            }
            $("#largeOutfitCarousel").stop().css("left", "-459px");
        }
        $("#signInDropDownlogin").removeClass("signinWidth");
        if (($("#signInDropDownlogin").outerWidth()) > 300) {
            setTimeout(function() {
                $("#signInDropDownlogin").addClass("signinWidth");
            },
            400);
        }
    } else {
        $("#myAccountBox").addClass("overActive").show("fade", 200);
        $(".sign-in-arrow").css("visibility", "visible");
        var b = 57 + ($("#headerAccountLink a").width() / 2);
        $("#myAccountBox .myaccount-arrow").css("right", b);
        $("#miniCartContiainer,#languageSelect").hide();
    }
}
var ajaxRefresh = false;
var noajaxloader = false;
var pixelId = "";
var currencyType = "";
var cartValue = "";
var outfitAdBagId = "";
var productadding = true;
var productVar = $("body");
var xx = 0;
var contextRoot='';
var sessionexpurl = contextRoot + "";
var internalServerError = contextRoot + "";
$(document).ajaxStart(function() {
    if (noajaxloader == false) {
        var b = $("<div></div>").addClass("ajax_overlay");
        var c = $("<div></div>").addClass("ajax_loader");
        $("body").append(b);
        $("body").append(c);
    }
    $(".prodDisplaySelectDropdown,#productSize").change(function(d) {
        productadding = true;
    });
    if (productadding == false) {
        if (outfitAdBagId != "") {
            productVar.find("#" + outfitAdBagId).find(".changed_input").css("display", "none");
            productVar.find("#" + outfitAdBagId).find(".adding_input").css("display", "block");
            productVar.find("#" + outfitAdBagId).find(".add-to-bag-shine").addClass("shift");
            setTimeout(function() {
                productVar.find("#" + outfitAdBagId).find(".add-to-bag-shine").removeClass("shift");
                productVar.find("#" + outfitAdBagId).find(".adding_input").css("display", "none");
                productVar.find("#" + outfitAdBagId).find(".added_input").addClass("added");
            },
            1000);
        } else {
            productVar.find(".changed_input").css("display", "none");
            productVar.find(".adding_input").css("display", "block");
            productVar.find(".add-to-bag-shine").addClass("shift");
            setTimeout(function() {
                productVar.find(".add-to-bag-shine").removeClass("shift");
                productVar.find(".adding_input").css("display", "none");
                productVar.find(".added_input").addClass("added");
            },
            1000);
        }
    }
}).ajaxStop(function() {
    if (noajaxloader == false) {
        setTimeout(function() {
            $(".ajax_overlay, .ajax_loader").remove();
            $(".ajax_loader").remove();
        },
        1000);
    }
    if (productadding == false) {
        setTimeout(function() {
            productVar.find(".changed_input").css("display", "block");
            productVar.find(".added_input").removeClass("added");
            productVar.find(".adding_input").css("display", "none");
            productVar.find(".add-to-bag-shine").removeClass("shift");
        },
        3000);
    }
});
$(document).ready(function(c) {
    var b = contextRoot + "/checkout/shop_cart.jsp";
    c(document).on("submit", ".submitFormAjax",
    function(k) {
        k.preventDefault();
        form = c(this);
        formClass = c(this).attr("class").split(" ")[1];
        formId = c(this).attr("id");
        inputOrderId = c(this).find("#orderId").val();
        var l = form.find(".productIndex").val();
        var j = "qtyCartChange_" + l;
        fieldsArray = form.serializeArray();
        fieldsArray.push({
            name: "formName",
            value: formId
        });
        fieldsArray = c.grep(fieldsArray,
        function(m, e) {
            return m.name != "successUrl";
        });
        fieldsArray = c.grep(fieldsArray,
        function(m, e) {
            return m.name != "errorUrl";
        });
        if (formId == "eGiftCardDetails") {
            productadding = true;
        }
        if (formId == "signInDropDown") {
            successUrl = document.referrer;
        } else {
            successUrl = c(this).closest("form").find("#successUrl").val();
        }
        var f = form.find("#addToBagproductId").val();
        var d = "addtocart_" + f;
        if (formId == "shippingForm" || formId == "billingForm") {
            var h = c(this).parent(".checkout-panel").height();
            c(".modal").css("height", h).show();
            c("body, html").animate({
                scrollTop: c("form").offset().top
            },
            "slow");
        }
        if (formId == "socialCreateProfileForm") {
            var g = c(this).closest("form").find("#login").val();
            c(this).closest("form").find("#confirmEmailSocialCreateProfile").val(g);
        }
        if (formId == "accountCreation" || formId == "addressCreationForm" || formId == "paymentCreationForm" || formId == "editProfileForm" || formId == "resetPasswordForm" || formId == "changePasswordForm" || formId == "resetPasswordEmailForm" || formId == "accountCompleteForm") {}
        if (formId == j || formId == "yourOrderForm" || formId == "giftCardForm") {
            noajaxloader = false;
            productadding = false;
            productVar = c(k.currentTarget);
        }
        if (formId == "addAllToBagForm") {
            noajaxloader = false;
            productadding = false;
            productVar = c(k.currentTarget).find("div#add_all");
        }
        jQuery.ajax({
            url: contextRoot + "/includes/ajax_form_submit.jsp",
            type: "post",
            data: fieldsArray,
            dataType: "json",
            cache: false,
            success: function(G) {
                noajaxloader = false;
                if (G.result == "success") {
                    if (formId == "addressCreationForm") {
                        location.href = successUrl;
                    }
                    if (formId == "accountCreation") {
                        registrationPage();
                    }
                    if (formId == "claimCouponCode") {
                        setTimeout(function() {
                            c("#couponapplied").show();
                            c("#shippingForm input.css-checkbox").customInput();
                            c("#billingForm input.css-checkbox").customInput();
                            c("input.css-checkbox").customInput();
                        },
                        1000);
                    }
                    if (formId == "sharePopup") {
                        if (c(".fave-share-product").find(".share-email").length != 0) {
                            var F = c(".share-email").attr("href").split("?")[1].split("&")[1].split("=")[1];
                            shareEmail(F);
                        }
                        if (c(".fave-share-product").find(".share_email").length != 0) {
                            var F = c(".share_email").attr("href").split("?")[1].split("&")[1].split("=")[1];
                            shareEmail(F);
                        }
                    }
                    if (formId == "signInDropDown") {
                        if (c("#signInDropDown").find("#signInDropDownlogin").length != 0) {
                            var D = c("#signInDropDownlogin").val();
                            loginPage(D);
                        }
                    }
                    if (formId == "signInForm") {
                        if (c("#signInForm").find("#accountlogin").length != 0) {
                            var D = c("#accountlogin").val();
                            loginPage(D);
                        }
                    }
                    if (formId == "checkoutSignin") {
                        if (c("#checkoutSignin").find("#signInModalEmail").length != 0) {
                            var D = c("#signInModalEmail").val();
                            loginPage(D);
                        }
                    }
                    if (formClass == "omniAdd") {
                        var E = c("div#orderitemcount").text();
                        var q = form.children(".omniSku").val();
                        if (E == 0) {
                            addToCartOmni(q);
                        } else {
                            addToCartOmniScAdd(q);
                        }
                    }
                    if (formId == "contactCreationForm") {
                        c("p.thanks_msg").show();
                        c("p.labeltxt").show();
                        c("div.field-missing-text").hide();
                        c("label,input").removeClass("field-missing-color");
                        c(".success_message").show();
                        c("input[type=text], textarea").val("");
                        return false;
                    }
                    if ((c("input#pdpPageSeoUrl").val() != undefined) && ((formId == "socialSignInDropDown") || (formId == "signInDropDown"))) {
                        if (G.errorofemployee == "true") {
                            location.href = b;
                            return false;
                        } else {
                            successUrl = c("input#pdpPageSeoUrl").val();
                            location.href = successUrl;
                            return false;
                        }
                    }
                    if ((c("input#outfitDetailPageSeoUrl").val() != undefined) && ((formId == "socialSignInDropDown") || (formId == "signInDropDown"))) {
                        if (G.errorofemployee == "true") {
                            location.href = b;
                            return false;
                        } else {
                            successUrl = c("input#outfitDetailPageSeoUrl").val();
                            location.href = successUrl;
                            return false;
                        }
                    }
                    if ((c("input#trendsUrl").val() != undefined) && ((formId == "socialSignInDropDown") || (formId == "signInDropDown"))) {
                        if (G.errorofemployee == "true") {
                            location.href = b;
                            return false;
                        } else {
                            successUrl = c("input#trendsUrl").val();
                            location.href = successUrl;
                            return false;
                        }
                    }
                    if ((c("input#outfitLargeSeoUrl").val() != undefined) && ((formId == "socialSignInDropDown") || (formId == "signInDropDown"))) {
                        if (G.errorofemployee == "true") {
                            location.href = b;
                            return false;
                        } else {
                            successUrl = c("input#outfitLargeSeoUrl").val();
                            location.href = successUrl;
                            return false;
                        }
                    }
                    if (G.errorofemployee == "true") {
                        if (formId == "checkoutSignin" || formId == "signInDropDown" || formId == "socialSignInDropDown" || formId == "signInForm") {
                            location.href = b;
                            return false;
                        }
                    }
                    if (formId == "changePasswordForm") {
                        c("#changePasswordDialog").dialog("close");
                        c(".password_changed").show();
                        return false;
                    }
                    if (formId == "newsletterSignup") {
                        var e = c("#password").val();
                        var w = c("#password").attr("placeholder");
                        if (e == w) {
                            e == "";
                            location.href = successUrl;
                        } else {
                            if (e != "") {
                                successUrl = contextRoot + "/account/index.jsp";
                                location.href = successUrl;
                            } else {
                                location.href = successUrl;
                            }
                        }
                    }
                    if (formId == "mailingListSignUpForm") {
                        var e = c("#mailingListSignUpForm #mailingListSignUplogin");
                        successUrl = contextRoot + "/stores/newsletter_signup.jsp?email=" + e.val();
                        location.href = successUrl;
                    }
                    if (formId == "mailingListSignUpFormConfirm") {
                        var r = c("#mailingListSignUpFormConfirm #mailingListSignUplogin");
                        successUrl = contextRoot + "/stores/newsletter_signup.jsp?email=" + r.val();
                    }
                    if (formId == "storeFinderForm") {
                        var A = G.country;
                        var m = G.zipcode;
                        var B = A.toLowerCase().replace(" ", "-");
                        var t = m.toLowerCase().replace(" ", "-");
                        successUrl = "/stores/search/" + B + "/25/" + t;
                        location.href = successUrl;
                    }
                    if (formId == "selectedViewFormUp") {
                        c("#selectedView").val("true");
                        c("#collapseSubNav").trigger("click");
                        return false;
                    }
                    if (formId == "selectedViewFormDown") {
                        c("#selectedView").val("false");
                        c("#showSubNav").trigger("click");
                        return false;
                    }
                    if (formId == "yourOrderForm") {
                        var y = c.trim(G.couponStatus);
                        noajaxloader = false;
                        jQuery.ajax({
                            url: "/includes/miniBagDetail.jsp?isRepriceRequired=true",
                            dataType: "html",
                            success: function(I) {
                                c("#miniCartContiainer").html(I);
                                noajaxloader = false;
                                var H = c("div#miniCartItems p#orderCount span").text();
                                c("div#orderitemcount").text(H);
                                c("#itemsInCartNotifier").html("<div class='itemsInCartNotifier_span'>" + H + "</div>");
                            }
                        });
                        noajaxloader = false;
                        jQuery.ajax({
                            url: "/checkout/includes/shop_cart_include.jsp",
                            type: "POST",
                            dataType: "html",
                            success: function(H) {
                                noajaxloader = false;
                                c("#cartContainer").replaceWith(H);
                                c("select").selectbox();
                                if (y == "true") {
                                    c("#couponapplied").show();
                                }
                                if (c("#shippingMethod").length > 0) {
                                    c.post(contextRoot + "/checkout/includes/update_ship_method.jsp", {
                                        shipMethod: c("#shippingMethod").val()
                                    },
                                    function(I) {
                                        c.ajax({
                                            url: contextRoot + "/checkout/includes/display_order_total.jsp",
                                            type: "get",
                                            cache: false,
                                            success: function(J) {
                                                c(".order-total-line").html(J);
                                            }
                                        });
                                    });
                                }
                                SetTabIndexForcheckOut();
                            }
                        });
                        return false;
                    }
                    if (formId == "sharePopup") {
                        c(".emailSentErrorMessage").hide();
                        c("input[type=text], textarea").val("");
                        c("input[name=checkBox]").attr("checked", false);
                        c("div.field-missing-text").hide();
                        c("label,input").removeClass("field-missing-color");
                        c(".success_message").show();
                    } else {
                        if (formId == "giftcardbalanceForm") {
                            c("#missingFields").empty().hide();
                            c("#showGiftCardBalance div").html(G.giftcardBalance);
                            formPlaceholderFix();
                            return false;
                        } else {
                            if (c(".checkout-container").hasClass("onePage") && formId != "reviewForm") {
                                checkoutOnePage(formId, G);
                            } else {
                                if (formId == "orderstatus") {
                                    var p = "/account/includes/order_id_encrypt.jsp?orderId=" + inputOrderId;
                                    c.ajax({
                                        url: p,
                                        type: "POST",
                                        dataType: "json",
                                        success: function(H) {
                                            successUrl = successUrl + "?orderId=" + H.orderId;
                                            location.href = successUrl;
                                        },
                                        error: function(J, H, I) {
                                            console.log("error");
                                        }
                                    });
                                } else {
                                    if (formId == "editGiftCard") {
                                        location.href = successUrl;
                                    } else {
                                        if (formId == j) {
                                            noajaxloader = false;
                                            jQuery.ajax({
                                                url: "/includes/miniBagDetail.jsp?isRepriceRequired=true",
                                                type: "POST",
                                                dataType: "html",
                                                success: function(I) {
                                                    c("#miniCartContiainer").html(I);
                                                    noajaxloader = false;
                                                    var H = c("div#miniCartItems p#orderCount span").text();
                                                    c("div#orderitemcount").text(H);
                                                    c("#itemsInCartNotifier").html("<div class='itemsInCartNotifier_span'>" + H + "</div>");
                                                }
                                            });
                                            noajaxloader = false;
                                            jQuery.ajax({
                                                url: "/checkout/includes/shop_cart_include.jsp",
                                                type: "POST",
                                                dataType: "html",
                                                success: function(K) {
                                                    c("#cartContainer").replaceWith(K);
                                                    c("#qtyUpdateErrormsg").hide();
                                                    c("#qtyUpdatesuccessmsg").show();
                                                    c("select").selectbox();
                                                    c("#cartTableContainer #content_1").jScrollPane();
                                                    formPlaceholderFix();
                                                    noajaxloader = false;
                                                    if (c("#shippingMethod").length > 0) {
                                                        c.post(contextRoot + "/checkout/includes/update_ship_method.jsp", {
                                                            shipMethod: c("#shippingMethod").val()
                                                        },
                                                        function(L) {
                                                            c.ajax({
                                                                url: contextRoot + "/checkout/includes/display_order_total.jsp",
                                                                type: "get",
                                                                cache: false,
                                                                success: function(M) {
                                                                    c(".order-total-line").html(M);
                                                                }
                                                            });
                                                        });
                                                    }
                                                    SetTabIndexForcheckOut();
                                                    var J = c("#" + formId + " select");
                                                    var H = c(J).attr("sb");
                                                    var I = "sbHolder_" + H;
                                                    c("#" + I).focus();
                                                }
                                            });
                                            return false;
                                        } else {
                                            if (formId == d) {
                                                productadding = false;
                                                if (c.browser.mozilla) {
                                                    productVar.find("#" + d).find(".changed_input").css("display", "none");
                                                    productVar.find("#" + d).find(".adding_input").css("display", "block");
                                                    productVar.find("#" + d).find(".add-to-bag-shine").addClass("shift");
                                                    setTimeout(function() {
                                                        productVar.find("#" + d).find(".add-to-bag-shine").removeClass("shift");
                                                        productVar.find("#" + d).find(".adding_input").css("display", "none");
                                                        productVar.find("#" + d).find(".added_input").addClass("added");
                                                    },
                                                    1000);
                                                    setTimeout(function() {
                                                        productVar.find("#" + d).find(".changed_input").css("display", "block");
                                                        productVar.find("#" + d).find(".added_input").removeClass("added");
                                                        productVar.find("#" + d).find(".adding_input").css("display", "none");
                                                        productVar.find("#" + d).find(".add-to-bag-shine").removeClass("shift");
                                                    },
                                                    3000);
                                                } else {
                                                    outfitAdBagId = d;
                                                    c(document).trigger("ajaxStart");
                                                }
                                                var o = c("#pageNameForCart").val();
                                                if (o != "Product Zoom View") {
                                                    setTimeout(function() {
                                                        commonAjaxCall("addToCart", "AddToCartEventPage", "isRepriceRequired");
                                                    },
                                                    1000);
                                                }
                                                if (o == "Product Quick View") {
                                                    noajaxloader = false;
                                                    var z = c("#addedfromyoumaylike").val();
                                                    if (z == "true") {
                                                        location.href = successUrl;
                                                        return false;
                                                    } else {
                                                        productadding = true;
                                                        jQuery.ajax({
                                                            url: "/checkout/includes/shop_cart_include.jsp",
                                                            type: "POST",
                                                            dataType: "html",
                                                            success: function(H) {
                                                                c("#cartContainer").replaceWith(H);
                                                                c("select").selectbox();
                                                                c("#cartTableContainer #content_1").jScrollPane();
                                                                noajaxloader = false;
                                                                if (c("#shippingMethod").length > 0) {
                                                                    c.post(contextRoot + "/checkout/includes/update_ship_method.jsp", {
                                                                        shipMethod: c("#shippingMethod").val()
                                                                    },
                                                                    function(I) {
                                                                        c.ajax({
                                                                            url: contextRoot + "/checkout/includes/display_order_total.jsp",
                                                                            type: "get",
                                                                            cache: false,
                                                                            success: function(J) {
                                                                                c(".order-total-line").html(J);
                                                                            }
                                                                        });
                                                                    });
                                                                }
                                                                SetTabIndexForcheckOut();
                                                            }
                                                        });
                                                    }
                                                }
                                                if (o == "Outfit Quick View") {
                                                    setTimeout(function() {
                                                        c(".outfit-quickview").dialog("close");
                                                    },
                                                    1050);
                                                }
                                                if (o == "Outfits") {
                                                    c(".large-product-view-details a").removeClass("ajaxCall");
                                                }
                                                if (o == "Product Zoom View") {
                                                    zoomViewCommonAjaxCall("addToCart", "AddToCartEventPage", "isRepriceRequired");
                                                } else {
                                                    console.log(JSON.stringify(G));
                                                    noajaxloader = false;
                                                }
                                            } else {
                                                if (formId == "giftCardForm") {
                                                    noajaxloader = false;
                                                    jQuery.ajax({
                                                        url: "/includes/miniBagDetail.jsp",
                                                        type: "POST",
                                                        dataType: "html",
                                                        success: function(I) {
                                                            noajaxloader = false;
                                                            c("#miniCartContiainer").html(I);
                                                            var H = c("div#miniCartItems p#orderCount span").text();
                                                            c("div#orderitemcount").text(H);
                                                            c("#itemsInCartNotifier").html("<div class='itemsInCartNotifier_span'>" + H + "</div>");
                                                        }
                                                    });
                                                    var n = c("#miniCartContiainer");
                                                    n.show();
                                                    setTimeout(function() {
                                                        n.hide();
                                                    },
                                                    3000);
                                                    return false;
                                                } else {
                                                    if (formId == "addAllToBagForm") {
                                                        c("#errorValidateBoxForAll").empty();
                                                        c(".addallcart-error").hide();
                                                        c(".addallcart-validate").empty();
                                                        c(".addallcart-validate").append(G.addAllToBagStatus);
                                                        c(".addallcart-validate").show();
                                                        commonAjaxCall("addToCart", "AddToCartEventPage", "true");
                                                    } else {
                                                        if (formId == "socialCheckEmailForm") {
                                                            var C = G.socailRequestVO.isCreateUser;
                                                            if (C) {
                                                                socialRegisterAjax(G.socailRequestVO);
                                                            } else {
                                                                socialSigninAjax(G.socailRequestVO);
                                                            }
                                                        } else {
                                                            if (formId == "signInDropDown" || formId == "socialSignInDropDown" || (c("#isHeaderLogin").val() == "true" && (formId == "socialCreateProfileForm" || formId == "resetSocialEmailForm"))) {
                                                                window.parent.location.href = successUrl;
                                                            } else {
                                                                window.location.href = successUrl;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if (G.result == "error") {
                        noajaxloader = false;
                        errorsObj = G.errors;
                        formId = G.formName;
                        if (formId == "signInForm" || formId == "signInDropDown" || formId == "checkoutSignin" || formId == "singin") {
                            var v = G.migratedUser;
                            if (v) {
                                errorUrl = c("input#migratedUrl").val();
                                if (formId == "signInDropDown") {
                                    window.parent.location.href = errorUrl + v;
                                } else {
                                    location.href = errorUrl + v;
                                }
                                return false;
                            }
                        }
                        if (formId == "newsletterSignup") {
                            if (G.newsLetterLogin == true) {
                                errorUrl = contextRoot + "/stores/includes/newsletter_invite_thanks.jsp?newsLetterLogin=true";
                                location.href = errorUrl;
                            }
                        }
                        if (formId == "resetPasswordForm") {
                            if (G.isEmailSendReset == true) {
                                var u = c("#login").val();
                                var v = c("input#migratedUser").val();
                                if (v == "true") {
                                    errorUrl = contextRoot + "/account/reset_password.jsp?isExisting=" + v + "&login=" + u;
                                } else {
                                    errorUrl = contextRoot + "/account/reset_password.jsp?login=" + u;
                                }
                                location.href = errorUrl;
                            }
                        }
                        if (formId == j) {
                            noajaxloader = false;
                            jQuery.ajax({
                                url: "/checkout/includes/shop_cart_include.jsp",
                                type: "POST",
                                dataType: "html",
                                success: function(I) {
                                    noajaxloader = false;
                                    var H;
                                    c("#cartContainer").replaceWith(I);
                                    for (i = 0; i < errorsObj.length; i++) {
                                        H = errorsObj[i].message;
                                    }
                                    c("#qtyUpdateErrormsg").append("<p>" + H + "</p>");
                                    c("#qtyUpdateErrormsg").show();
                                    c("#qtyUpdatesuccessmsg").hide();
                                    c("select").selectbox();
                                    SetTabIndexForcheckOut();
                                }
                            });
                        }
                        renderErrors(formId, errorsObj);
                        if (formId == "signInForm" || formId == "resetPasswordForm" || formId == "socialSignInDropDown" || formId == "signInDropDown") {
                            if (G.passwordWrongAttempts == 1) {
                                alert("You have reached the maximum login attempts. If you try to login again with wrong password your account will be locked.");
                            }
                        }
                        if (formId == "signInForm" || formId == "accountCreation") {
                            if (c(".sessionError").is(":visible")) {
                                c(".sessionError").hide();
                            }
                        } else {
                            if (formId == "sharePopup") {
                                c(".success_message").hide();
                                c(".emailSentErrorMessage").show();
                                c("div.field-missing-text").show();
                            }
                        }
                        if (formId == "signInDropDown") {
                            c("#signInBox").show();
                            c("#signInDropDownlogin").focus();
                            setIframeHeight();
                        } else {
                            if ((c("#isHeaderLogin").val() == "true" && (formId == "socialSignInDropDown" || formId == "socialCreateProfileForm" || formId == "resetSocialEmailForm"))) {
                                setIframeHeight();
                            }
                        }
                    }
                }
            },
            error: function(n, e, m) {
                if (formId == "signInDropDown" || formId == "socialSignInDropDown" || (c("#isHeaderLogin").val() == "true" && (formId == "socialCreateProfileForm" || formId == "resetSocialEmailForm"))) {
                    window.parent.location.href = internalServerError;
                } else {
                    if (n.status == "409") {
                        location.href = sessionexpurl;
                    } else {
                        location.href = internalServerError;
                    }
                }
            }
        });
    });
    c(document).on("click", ".ajaxButton",
    function(d) {
        d.preventDefault();
        buttonId = c(this).attr("id");
        if (typeof buttonId === "undefined") {
            buttonId = c(this).attr("rel");
        }
        buttonHref = c(this).attr("href");
        openAjaxModal(buttonHref, buttonId);
    });
});
function doAjaxRefreshOld(c, d, b) {
    $("#" + c).load(d,
    function() {
        if (b.length > 1) {
            script = b.split(",");
            for (i = 0; i < script.length; i++) {
                $.getScript(script[i],
                function(e, g, f) {});
            }
        }
        ajaxRefresh = true;
    });
}
function doAjaxRefresh(b, c) {
    $("#" + b).load(c,
    function() {
        ajaxRefresh = true;
    });
}
function openAjaxModal(buttonHref, buttonId) {
    $(".ui-dialog-content").dialog("destroy");
    $("#dialog-message").remove();
    if ($("#" + buttonId + "Modal").length == 0) {
        $("body").append('<div id="' + buttonId + 'Modal"></div>');
    }
    $("#" + buttonId + "Modal").load(buttonHref);
    var wWidth = $(window).width();
    var wHeight = $(window).height();
    var popWidth = eval(buttonId).width;
    var popHeight = eval(buttonId).height;
    var yposition = (wHeight / 2) - ((popWidth * 0.7) / 2);
    var xposition = (wWidth / 2) - (popWidth / 2);
    $("#" + buttonId + "Modal").dialog({
        height: "auto",
        minWidth: eval(buttonId).width,
        minHeight: eval(buttonId).height,
        modal: true,
        bgiframe: true,
        draggable: true,
        resizable: false,
        autoOpen: true,
        closeOnEscape: true,
        hide: "fade",
        show: "fade",
        position: [xposition, yposition]
    });
}
var i = 1;
$("head").append('<div id="facebookpixel"' + i + "></div>");
$("body").append('<div id="socialpixel"></div>');
function commonAjaxCall(b, g, h) {
    var f = $("#productPriceNew").val();
    var c = $("#AddAllToBag").val();
    var e = Math.random();
    var d = "/includes/common_ajax.jsp?pageNameValue=" + b + "&productPrice=" + $("#productPriceNew").val() + "&addBag=" + c + "&eventName=" + g + "&isRepriceRequired=true&randomNumber=" + e;
    jQuery.ajax({
        url: d,
        type: "GET",
        dataType: "html",
        success: function(n) {
            $("#miniCartContiainer").html(n);
            noajaxloader = false;
            if ($("#miniCartItems_scroll").height() > 180) {
                $("#content_1, #miniCartItems_scroll").jScrollPane();
            }
            if ($("#miniCartItems_scroll").height() > 200) {
                $("#content_1, #miniCartItems_scroll").jScrollPane();
            }
            var l = $("div#miniCartItems p#orderCount span").text();
            $("div#orderitemcount").text(l);
            $("#itemsInCartNotifier").html("<div class='itemsInCartNotifier_span'>" + l + "</div>");
            $("#miniCartContiainer").show().delay(300).hide();
            var k = $("#miniCartContiainer");
            k.show();
            setTimeout(function() {
                k.hide();
            },
            3000);
            pixelId = $("input#ajaxpixelId").val();
            currencyType = $("input#ajaxcurrencyType").val();
            cartValue = $("input#ajaxcartValue").val();
            var j = $("input#ajaxuserLocale").val();
            var m = $("div#socialPixelImageDiv").html();
            $("body #socialpixel").html(m);
            facebookPixelInclude(pixelId, currencyType, cartValue, j);
            $("div#socialPixelImageDiv").empty();
            return false;
        },
        error: function(l, j, k) {
            console.log(l, j, k);
            if (l.status == "409") {
                location.href = sessionexpurl;
            } else {
                location.href = internalServerError;
            }
        }
    });
}
function zoomViewCommonAjaxCall(b, f, g) {
    var e = $("#productPriceNew").val();
    var c = $("#AddAllToBag").val();
    var d = "/includes/common_ajax.jsp?pageNameValue=" + b + "&productPrice=" + $("#productPriceNew").val() + "&addBag=" + c + "&eventName=" + f + "&isRepriceRequired=true";
    jQuery.ajax({
        url: d,
        type: "GET",
        dataType: "html",
        success: function(m) {
            $(parent.document).find("#miniCartContiainer").html(m);
            noajaxloader = false;
            if ($(parent.document).find("#miniCartItems_scroll").height() > 180) {
                $(parent.document).find("#content_1, #miniCartItems_scroll").jScrollPane();
            }
            if ($(parent.document).find("#miniCartItems_scroll").height() > 200) {
                $(parent.document).find("#content_1, #miniCartItems_scroll").jScrollPane();
            }
            var k = $(parent.document).find("div#miniCartItems p#orderCount span").text();
            $(parent.document).find("div#orderitemcount").text(k);
            $(parent.document).find("#itemsInCartNotifier").html("<div class='itemsInCartNotifier_span'>" + k + "</div>");
            $(parent.document).find("#miniCartContiainer").show().delay(300).hide();
            var j = $(parent.document).find("#miniCartContiainer");
            j.show();
            setTimeout(function() {
                j.hide();
            },
            3000);
            pixelId = $(parent.document).find("input#ajaxpixelId").val();
            currencyType = $(parent.document).find("input#ajaxcurrencyType").val();
            cartValue = $(parent.document).find("input#ajaxcartValue").val();
            var h = $(parent.document).find("input#ajaxuserLocale").val();
            var l = $(parent.document).find("div#socialPixelImageDiv").html();
            $(parent.document).find("body #socialpixel").html(l);
            facebookPixelInclude(pixelId, currencyType, cartValue, h);
            $(parent.document).find("div#socialPixelImageDiv").empty();
            return false;
        },
        error: function(k, h, j) {
            console.log(k, h, j);
            if (k.status == "409") {
                location.href = sessionexpurl;
            } else {
                location.href = internalServerError;
            }
        }
    });
}
function facebookPixelInclude(f, c, h, b) {
    var g = "//connect.facebook.net/" + b + "/fp.js";
    var e = 'var fb_param = {};fb_param.pixel_id = "' + f + '";fb_param.value = "' + h + '";fb_param.currency = "' + c + '";(function(){var fpw = document.createElement("script");fpw.async = true;fpw.src = "' + g + '";var ref = document.getElementsByTagName("script")[0]; ref.parentNode.insertBefore(fpw, ref);})();';
    var j = '<script type="text/javascript">';
    var d = "<\/script>";
    total = j + e + d;
    $("head #facebookpixel").empty().append(total);
}
function loadSocialPixel(c) {
    var b;
    jQuery.ajax({
        url: "/pixelTracking/socialPixel.jsp?eventName=" + c + "&addBag=" + b,
        type: "GET",
        dataType: "html",
        success: function(d) {
            $("body #socialpixel").html(d);
        }
    });
}
function addToAnonyFavorites(c, f, d, b, e) {
    localStorage.setItem("productPrice", d);
}
function loadFacebookPixel(b) {
    var e = $("#productPriceNew").val();
    var c = $("#AddAllToBag").val();
    var d = "/pixelTracking/facebookPixel.jsp?pageNameValue=" + b + "&productPrice=" + $("#productPriceNew").val() + "&addBag=" + c;
    jQuery.ajax({
        url: d,
        type: "GET",
        dataType: "json",
        success: function(f) {
            pixelId = f.pixelId;
            currencyType = f.currencyType;
            cartValue = f.cartValue;
            jQuery.ajax({
                url: "/pixelTracking/facebookPixel_include.jsp",
                data: {
                    pixelId: pixelId,
                    cartValue: cartValue,
                    currencyType: currencyType
                },
                type: "GET",
                dataType: "html",
                success: function(g) {
                    $("head #facebookpixel").html(g);
                }
            });
        },
        error: function(h, f, g) {
            console.log(h, f, g);
        }
    });
}
function largeviewindex() {
    $(".outfit_container").find(".lg-grid-next").each(function() {
        if ($(this).is(":visible")) {
            $(this).attr("tabindex", "32");
        }
    });
    $(".outfit_container").find(".lg-grid-next,.lg-grid-prev").keypress(function(b) {
        if (b.keyCode == 13) {
            $(this).trigger("click");
            setTimeout(function() {
                $("#largeOutfitCarousel").find(".category-large-container").removeAttr("tabindex");
                $("#largeOutfitCarousel").find(".category-large-container a").removeAttr("tabindex");
                $("#largeOutfitCarousel").find(".category-large-container").each(function() {
                    if ($(this).css("opacity") == 1) {
                        $(this).attr("tabindex", "31");
                        $(this).find("a").each(function() {
                            $(this).attr("tabindex", "31");
                        });
                        $(this).focus();
                    }
                });
                $(".outfit_container").find(".lg-grid-prev").removeAttr("tabindex");
                $(".outfit_container").find(".lg-grid-prev").each(function() {
                    if ($(this).is(":visible")) {
                        $(this).attr("tabindex", "30");
                    }
                });
            },
            200);
            b.preventDefault();
        }
    });
    $("#largeOutfitCarousel").find(".share-icon").focus(function() {
        $(this).trigger("mouseenter");
        setTimeout(function() {
            $("#largeOutfitCarousel").find(".hero-tooltip-content1").find("iframe").each(function() {
                $(this).attr("tabindex", "31");
            });
            $("#largeOutfitCarousel").find(".hero-tooltip-content1 a.pin-it-buttona img,.hero-tooltip-content1 table tr td a").attr("tabindex", "31");
            if ($("#largeOutfitCarousel").find(".hero-tooltip-content1 .share-email").length > 0) {
                $("#largeOutfitCarousel").find(".hero-tooltip-content1 .share-email").attr("tabindex", "31");
            }
        },
        3000);
    });
}
$(document).ready(function($) {
    KeyboardSetting();
    SetFocusToControlShop();
    if ($(".have_card").length) {
        $(".have_card").focus();
    }
    var pdp = $("#productDetailsPageContainer").length;
    $(".sbSelector").each(function() {
        if ($(this).text() == "Select a Value") {
            $(this).css("text-transform", "none");
        }
    });
    $(".sbOptions li a").each(function() {
        if ($(this).text() == "Select a Value") {
            $(this).css("text-transform", "none");
        }
    });
    largeviewindex();
    largeViewlistingindex();
    var id = $("body").attr("id");
    if (id == "en_CA") {
        if ($.browser.msie && parseInt($.browser.version, 10) > 8) {
            if (pdp == 1) {
                $("span.mailingListSignUpForm_submit").css("top", "1px");
            }
        }
    }
    $(".pdp-description-tabs a").click(function(e) {
        $(".pdp-description-tabs a").attr("tabindex", "32");
    });
    $("#mainContent").append('<div style="clear:both"></div>');
    refreshShareSection();
    $("#categoryList .favorite-actions .share-links .share-email").on("click", sharePopup);
    function sourceSwap(obj) {
        var $this = obj;
        if (obj.hasClass("category-large-container")) {
            var newSource = $this.find("a.AlternativeImageClass").data("alt-src");
            $this.find("a.AlternativeImageClass").data("alt-src", $this.find("img").attr("src"));
            $this.find("img").attr("src", newSource);
        } else {
            var newSource = $this.data("alt-src");
            $this.data("alt-src", $this.find("img").attr("src"));
            $this.find("img").attr("src", newSource);
        }
    }
    var isiPad = (navigator.userAgent.match(/iPad/i) != null);
    if (!isiPad) {
        $(document).on({
            mouseleave: function() {
                if ($(".product_image_lazy li").hasClass("rolloverActive")) {
                    var objN = $(".product_image_lazy li.rolloverActive");
                    sourceSwap(objN);
                    $(".product_image_lazy li").removeClass("rolloverActive");
                }
                if ($(".category-list li").hasClass("rolloverActive")) {
                    var objN = $(".category-list li.rolloverActive");
                    sourceSwap(objN);
                    $(".category-list li").removeClass("rolloverActive");
                }
                sourceSwap($(this));
                $(this).find(".fave-share-product").hide();
            },
            mouseenter: function() {
                $(".product-panel-active").hide();
                $(this).find(".product-panel-active").show();
                $(this).find(".fave-share-product").show();
                sourceSwap($(this));
            }
        },
        "#productGridContainer .product-panel-small,#categoryGrid .category-medium-view, #categoryList .product-panel-small, #productGrids .category-large-container a");
        $(".product-panel-small").focus(function() {
            $(".hero-tooltip-content1").css("display", "none");
            if ($(".product_image_lazy li").hasClass("rolloverActive")) {
                var objN = $(".product_image_lazy li.rolloverActive");
                sourceSwap(objN);
                $(".product_image_lazy li").removeClass("rolloverActive");
            }
            if ($(".category-list li").hasClass("rolloverActive")) {
                var objN = $(".category-list li.rolloverActive");
                sourceSwap(objN);
                $(".category-list li").removeClass("rolloverActive");
            }
            $(".product-panel-active").hide();
            $(this).find(".product-panel-active").show();
            $(this).addClass("rolloverActive");
            $(this).trigger("mouseenter");
        });
        $(".description").on("focus",
        function() {
            var anchorpath = $(this).children("a").attr("href");
            $(this).on("keypress",
            function(event) {
                var keycode = (event.keyCode ? event.keyCode: event.which);
                if (keycode == "13") {
                    window.location = anchorpath;
                }
                event.stopPropagation();
            });
        });
        $(".product-panel-active img,.category-large-container img").on("focus",
        function() {
            var anchorimgpath = $(this).parent("a").attr("href");
            $(this).on("keypress",
            function(event) {
                var keycode = (event.keyCode ? event.keyCode: event.which);
                if (keycode == "13") {
                    window.location = anchorimgpath;
                }
                event.stopPropagation();
            });
        });
        $("li.category-large-container div img").each(function() {
            $(this).attr("tabindex", "1");
            var anchorimgpathlarge = $(this).parent("a").attr("href");
            $(this).on("keypress",
            function(event) {
                var keycode = (event.keyCode ? event.keyCode: event.which);
                if (keycode == "13") {
                    window.location = anchorimgpathlarge;
                }
                event.stopPropagation();
            });
        });
        $(document).on("focus", "#addToBag",
        function() {
            $(this).trigger("hover");
            $(this).on("keypress",
            function(event) {
                var keycode = (event.keyCode ? event.keyCode: event.which);
                if (keycode == "13") {
                    $(this).trigger("click");
                }
                event.stopPropagation();
            });
        });
        $("select").selectbox();
        $("#color-content .fave-share-product .share_pdp").on("focusin",
        function() {
            $(this).trigger("mouseenter");
            setTimeout(function() {
                $(".hero-tooltip-content1 iframe").each(function() {
                    $(this).attr("tabindex", "35");
                });
                $(".hero-tooltip-content1 a.pin-it-buttona img,.hero-tooltip-content1 table tr td a").attr("tabindex", "35");
            },
            3000);
            $("#color-content .hero-tooltip-content1 a.share_email").removeAttr("tabindex").attr("tabindex", "35");
        });
        $(".action-icons .share-icon,.fave-share-product .share_pdp").on("focus",
        function() {
            setTimeout(function() {
                $(".hero-tooltip-content1 iframe").each(function() {
                    $(this).attr("tabindex", "30");
                });
                $(".hero-tooltip-content1 a.pin-it-button a img,.hero-tooltip-content1 table tr td a").attr("tabindex", "30");
            },
            3000);
            $(this).next(".hero-tooltip-content1").children("a.share-email").attr("tabindex", "30").on("focusin",
            function() {
                $(this).css("border", "1px solid #AB9259");
            }).on("focusout",
            function() {
                $(this).css("border", "none");
            });
        });
        $(".category-large-container .action-icons .share-icon").on("focus",
        function() {
            setTimeout(function() {
                $(".hero-tooltip-content1 iframe").each(function() {
                    $(this).attr("tabindex", "31");
                });
                $(".hero-tooltip-content1 a.pin-it-button a img,.hero-tooltip-content1 table tr td a").attr("tabindex", "31");
            },
            3000);
            $(this).next(".hero-tooltip-content1").children("a.share-email").attr("tabindex", "31").on("focusin",
            function() {
                $(this).css("border", "1px solid #AB9259");
            }).on("focusout",
            function() {
                $(this).css("border", "none");
            });
        });
        $("#favoritedItemsList .favorite-actions .share-icon").on("focusin",
        function() {
            $(this).trigger("mouseenter");
            setTimeout(function() {
                $(".hero-tooltip-content1 iframe").each(function() {
                    $(this).attr("tabindex", "33");
                });
                $(".hero-tooltip-content1 a.pin-it-button a img,.hero-tooltip-content1 table tr td a").attr("tabindex", "33");
            },
            2500);
            $(this).next(".hero-tooltip-content1").children("a.share-email").attr("tabindex", "33");
        });
        $(document).on("focusin", ".hero-tooltip-content1 table tr td a",
        function() {
            var anchorhref1 = $(this).attr("data-pin-href");
            $(document).on("keypress",
            function(event) {
                var keycode = (event.keyCode ? event.keyCode: event.which);
                if (keycode == "13") {
                    location.href = anchorhref1;
                }
                event.stopPropagation();
            });
        });
        $(".hero-tooltip-content1 a.share-email, .hero-tooltip-content1 a.share_email").on("focusin",
        function() {
            $(this).css("border", "1px solid orange");
        }).on("focusout",
        function() {
            $(this).css("border", "1px solid #AFAAA0");
        });
        $(document).on("focusin", ".hero-tooltip-content1 a.pin-it-buttona img,.inner ul.group li a img",
        function() {
            var anchorhref = $(this).parent("a").attr("href");
            $(document).on("keypress",
            function(event) {
                var keycode = (event.keyCode ? event.keyCode: event.which);
                if (keycode == "13") {
                    location.href = anchorhref;
                }
                event.stopPropagation();
            });
        });
        $(".action-icons .unfavorite-heart").on("focusin",
        function() {
            $(".action-icons .hero-tooltip-content1").css("display", "none");
        });
        $("ul#categoryList li.category-medium-view").each(function() {
            $(this).attr("tabindex", "30");
            $(this).find(".favorite-actions .share-icon").on("focus",
            function() {
                setTimeout(function() {
                    $(".hero-tooltip-content1 iframe").each(function() {
                        $(this).attr("tabindex", "30");
                    });
                    $(".hero-tooltip-content1 a.pin-it-button a img,.hero-tooltip-content1 table tr td a").attr("tabindex", "30");
                },
                2500);
                $(this).next(".hero-tooltip-content1").children("a.share-email").attr("tabindex", "30").on("focusin",
                function() {
                    $(this).css("border", "1px solid #AB9259");
                }).on("focusout",
                function() {
                    $(this).css("border", "none");
                });
            });
            $(this).find("img").attr("tabindex", "30");
            $(this).on("focus",
            function() {
                $(".fave-share-product").css("display", "none");
                $(".favorite-actions").css("display", "none");
                $(this).find(".fave-share-product").css("display", "block");
                $(this).find(".favorite-actions").css("display", "block");
            }).on("mouseover",
            function() {
                $(this).find(".fave-share-product").css("display", "block");
                $(this).find(".favorite-actions").css("display", "block");
            }).on("mouseenter",
            function() {
                $(this).find(".fave-share-product").css("display", "block");
                $(this).find(".favorite-actions").css("display", "block");
            }).on("mouseleave",
            function() {
                $(this).find(".fave-share-product").css("display", "none");
                $(this).find(".favorite-actions").css("display", "none");
            });
            $(this).find("img").each(function() {
                $(this).on("focus",
                function() {
                    var imagepath11 = $(this).parent().attr("href");
                    $(this).on("keydown",
                    function(event) {
                        var keycode = (event.keyCode ? event.keyCode: event.which);
                        if (keycode == "13") {
                            location.href = imagepath11;
                        }
                        event.stopPropagation();
                    });
                    $(this).parent("a").siblings(".fave-share-product").css("display", "block");
                    $(this).parent("a").siblings(".fave-share-product").children(".favorite-actions").css("display", "block");
                }).on("mouseover",
                function() {
                    $(this).parent("a").siblings(".fave-share-product").css("display", "block");
                    $(this).parent("a").siblings(".fave-share-product").children(".favorite-actions").css("display", "block");
                }).on("mouseenter",
                function() {
                    $(this).parent("a").siblings(".fave-share-product").css("display", "block");
                    $(this).parent("a").siblings(".fave-share-product").children(".favorite-actions").css("display", "block");
                }).on("keydown",
                function() {
                    if (event.keyCode == 13) {
                        location.href = $(this).parent("a").attr("href");
                    }
                });
            });
            $(this).find("h3").attr("tabindex", "30");
            $(this).find("h3").each(function() {
                $(this).on("focus",
                function() {
                    var h3path11 = $(this).children("a").attr("href");
                    $(this).on("keydown",
                    function(event) {
                        var keycode = (event.keyCode ? event.keyCode: event.which);
                        if (keycode == "13") {
                            location.href = h3path11;
                        }
                        event.stopPropagation();
                    });
                    $(this).siblings(".fave-share-product").css("display", "block");
                    $(this).siblings(".fave-share-product").children(".favorite-actions").css("display", "block");
                }).on("mouseover",
                function() {
                    $(this).siblings(".fave-share-product").css("display", "block");
                    $(this).siblings(".fave-share-product").children(".favorite-actions").css("display", "block");
                }).on("mouseenter",
                function() {
                    $(this).siblings(".fave-share-product").css("display", "block");
                    $(this).siblings(".fave-share-product").children(".favorite-actions").css("display", "block");
                }).on("mouseleave",
                function() {
                    $(this).siblings(".fave-share-product").css("display", "none");
                    $(this).siblings(".fave-share-product").children(".favorite-actions").css("display", "none");
                }).on("mouseout",
                function() {
                    $(this).siblings(".fave-share-product").css("display", "none");
                    $(this).siblings(".fave-share-product").children(".favorite-actions").css("display", "none");
                }).on("keydown",
                function() {
                    if (event.keyCode == 13) {
                        location.href = $(this).children("a").attr("href");
                    }
                });
            });
        });
        $(".outfit-btn input").on("focus",
        function() {
            $(this).trigger("mouseenter");
            $(this).on("keypress",
            function(event) {
                var keycode = (event.keyCode ? event.keyCode: event.which);
                if (keycode == "13") {
                    $(this).trigger("click");
                }
                event.stopPropagation();
            });
        });
        $(".outfit-btn input").on("focusout",
        function() {
            $(this).trigger("mouseleave");
        });
        $(".share_btn input").on("focus",
        function() {
            $(this).trigger("mouseenter");
        });
        if ($("#largeOutfitCarousel div :eq(0)").has("theme")) {}
        $(".large-product-view-details .view-detail-pop").on("focusout",
        function(e) {
            $("#outfitItemsContainer .flyout_close").focus();
            $(".size-container .sbHolder").removeAttr("tab-index").attr("tabindex", "30");
            $(".size-container .sbHolder a").removeAttr("tabindex");
            $(".qty-container.outfit_space_space .sbHolder").removeAttr("tab-index").attr("tabindex", "30");
            $(".qty-container.outfit_space_space .sbHolder a").removeAttr("tabindex");
            e.stopPropagation();
        });
        $(document).on("focusin", "#outfitItemsContainer .flyout_close",
        function() {
            $(this).on("keydown",
            function(event) {
                var keycode = (event.keyCode ? event.keyCode: event.which);
                if (keycode == "13") {
                    $(this).trigger("click");
                    $("#outfitItemsContainer").fadeOut();
                    setTimeout(function() {
                        $(".category-large-container.onlyOneProd").focus();
                    },
                    1000);
                }
                event.stopPropagation();
            });
        });
        $(".inner ul.group li a img,li .item-details h3").on("focus",
        function() {
            $(this).parent().next().css("display", "block");
        });
        $("li .item-details h3").on("focusout",
        function() {
            $(".fave-share-product.group").css("display", "none");
        });
        $("li .item-details h3").on("focus",
        function() {
            $(".fave-share-product.group").css("display", "block");
        });
        $("ul#favoritedItemsList li").on("focusout",
        function() {
            $(".item-details").removeAttr("style");
            $(this).find(".item-details").css({
                display: "inline-block",
                padding: "2px 1px 2px 1px",
                height: "100%"
            });
        }).bind("focusin",
        function() {
            $(".item-details").removeAttr("style");
            $(this).find(".item-details").css({
                display: "inline-block",
                padding: "2px 1px 2px 1px",
                height: "100%"
            });
        });
        $(".favorite-actions .deleteFavourites,.favorite-actions .view-icon").on("focusin",
        function() {
            $(".hero-tooltip-content1.share-links").css("display", "none");
        });
        $(".favanchorimg img").on("focusin",
        function() {
            var favanchorpath = $(this).parent().attr("href");
            $(this).on("keydown",
            function(event) {
                var keycode = (event.keyCode ? event.keyCode: event.which);
                if (keycode == "13") {
                    location.href = favanchorpath;
                }
                event.stopPropagation();
            });
        });
        $(".favanchorimg h3").on("focusin",
        function() {
            var favanchorpath1 = $(this).parent().attr("href");
            $(this).on("keydown",
            function(event) {
                var keycode = (event.keyCode ? event.keyCode: event.which);
                if (keycode == "13") {
                    event.preventDefault();
                    location.href = favanchorpath1;
                }
                event.stopPropagation();
            });
        });
        $(".changed_input.add_all").on("focus",
        function() {
            $(this).on("keydown",
            function(event) {
                var keycode = (event.keyCode ? event.keyCode: event.which);
                if (keycode == "13") {
                    $(this).trigger("submit");
                }
                event.stopPropagation();
            });
        });
        $(document).on("focusin", ".close-search",
        function() {
            $(this).on("keydown",
            function(event) {
                var keycode = (event.keyCode ? event.keyCode: event.which);
                if (event.shiftKey && keycode == 9) {} else {
                    if (keycode == 9) {
                        $(this).trigger("click");
                    }
                }
                event.stopPropagation();
            });
        });
        $(document).on("focusin", "#imagesBox_swatches .s7thumb",
        function() {
            if ($.browser.msie && $.browser.version == 9) {
                $(this).on("keydown",
                function(event) {
                    var keycode = (event.keyCode ? event.keyCode: event.which);
                    if (keycode == "13") {
                        $(this).trigger("click");
                        return false;
                    }
                });
            }
        });
    }
    $("#categoryList .category-medium-view, #productGridContainer .product-panel-small,#categoryGrid .category-medium-view, #categoryList .product-panel-small, #productGrids .category-large-container a").bind("touchstart",
    function(e) {
        if ($(".product_image_lazy li").hasClass("rolloverActive")) {
            var objN = $(".product_image_lazy li.rolloverActive");
            sourceSwap(objN);
            $(".product_image_lazy li").removeClass("rolloverActive");
        }
        sourceSwap($(this));
        $(this).addClass("rolloverActive");
    });
    $("#categoryGrid #categoryList .fave-share-product .favorite-actions a.unfavorite-heart").bind("touchstart",
    function(e) {
        $(".tooltip").tooltipster({
            theme: ".my-custom-theme"
        });
    });
    $("#navContainer,#mainContent,#footer").bind("touchstart",
    function(e) {
        var container = $(".product_image_lazy");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            if ($(".product_image_lazy li").hasClass("rolloverActive")) {
                var objN = $(".product_image_lazy li.rolloverActive");
                sourceSwap(objN);
                $(".product_image_lazy li").removeClass("rolloverActive");
            }
        }
    });
    $("html").on("click",
    function(e) {
        var container = $("#productQuickviewModal");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            if ($(".ui-dialog").css("display") == "block") {
                $(".tooltipster-fade-show").css("opacity", 0);
            }
        }
    });
    $(".category-medium-view h3").bind("touchstart",
    function(e) {
        location.href = $(this).find("a").attr("href");
    });
    checkInventory();
    outfitCheckInventory();
    outfitLargeQuickViewCheckInventory();
    $(document).on("click", "#SaveChang",
    function(e) {
        e.preventDefault();
        var inputval = $("#giftCardAmount :selected").val();
        if (inputval == "other") {
            var maxVal = parseInt($("#giftCardMaxVal").val());
            var minVal = parseInt($("#giftCardMinVal").val());
            var dropDownAmount = $("#SelectInput").val();
            if (dropDownAmount == "") {
                var eval = $("#emptyInputAmt").val();
                $("#giftCardAmtErr").html(eval).show();
                errMsg = $("#missingtextAmount").val();
                $("#missingFields").html(errMsg).show();
                return false;
            }
            var n = dropDownAmount.indexOf(".");
            n = parseInt(n);
            if (n > 0) {
                var decimalPlaces = dropDownAmount.length - n - 1;
                if (parseInt(decimalPlaces) > 2) {
                    var eval1 = $("#emptyInputAmtRange").val();
                    var eval2 = $("#emptyInputAmtDollar").val();
                    $("#giftCardAmtErr").html(eval1 + minVal + eval2 + maxVal).show();
                    errMsg = $("#missingtextAmount").val();
                    $("#missingFields").html(errMsg).show();
                    return false;
                }
            }
            dropDownAmount = parseInt(dropDownAmount);
            if (! (dropDownAmount > minVal && dropDownAmount <= maxVal)) {
                var eval1 = $("#emptyInputAmtRange").val();
                var eval2 = $("#emptyInputAmtDollar").val();
                $("#giftCardAmtErr").html(eval1 + minVal + eval2 + maxVal).show();
                errMsg = $("#missingtextAmount").val();
                $("#missingFields").html(errMsg).show();
                return false;
            }
        }
        var GiftCardSelVal = $("#giftCardAmount :selected").val();
        if (GiftCardSelVal != "0") {
            var SelVal = $("#send_by_dropdown :selected").val();
            if (SelVal == "false") {
                return false;
            } else {
                GiftCardSelVal = GiftCardSelVal == "other" ? $("#SelectInput").val() : GiftCardSelVal;
                $("#FirstContentMail").hide();
                $("#SecondContentMail").show();
                $("div.ui-dialog").css("width", "584px");
                if ($.browser.msie && $.browser.version == 9) {
                    $("div#giftcardTypechanged").parent("#productQuickviewModal").addClass("onlyforeditgiftcard");
                }
                $("#giftCardAmt").val(GiftCardSelVal);
            }
        } else {
            errMsg = $("#missingAmount").val();
            $("#missingFields").html(errMsg).show();
            return false;
        }
    });
    $(document).on("click", "#openElectronicPopup",
    function(e) {
        e.preventDefault();
        var inputval = $("#giftCardAmount :selected").val();
        if (inputval == "other") {
            var maxVal = parseInt($("#giftCardMaxVal").val());
            var minVal = parseInt($("#giftCardMinVal").val());
            var dropDownAmount = $("#SelectInput").val();
            if (dropDownAmount == "") {
                var eval = $("#emptyInputAmt").val();
                $("#giftCardAmtErr").html(eval).show();
                errMsg = $("#missingtextAmount").val();
                $("#missingFields").html(errMsg).show();
                return false;
            }
            dropDownAmount = parseInt(dropDownAmount);
            if (! (dropDownAmount > minVal && dropDownAmount < maxVal)) {
                var eval1 = $("#emptyInputAmtRange").val();
                var eval2 = $("#emptyInputAmtDollar").val();
                $("#giftCardAmtErr").html(eval1 + minVal + eval2 + maxVal).show();
                errMsg = $("#missingtextAmount").val();
                $("#missingFields").html(errMsg).show();
                return false;
            } else {
                $("#giftCardAmtErr").empty();
                $("#missingFields").empty();
                $("#giftCardAmtErr").hide();
                $("#missingFields").hide();
                $("#editGiftCard").submit();
            }
        } else {
            if (inputval == 0) {
                errMsg = $("#missingAmount").val();
                $("#missingFields").html(errMsg).show();
                return false;
            } else {
                $("#editGiftCard").submit();
            }
        }
    });
    $(document).on("change", "#send_by_dropdown",
    function(e) {
        var SelVal = $("#send_by_dropdown :selected").val();
        var commerceId = $("#giftCommerceId").val();
        var giftProductId = $("#giftProductId").val();
        $.ajax({
            url: "/checkout/includes/edit_gift_card_details.jsp?commerceId=" + commerceId + "&giftCardprodId=" + giftProductId + "&selectedAmount=" + 0 + "&giftCardType=" + SelVal,
            type: "POST",
            dataType: "html",
            success: function(data) {
                $("#giftcardTypechanged").replaceWith(data);
                $("select").selectbox();
                $("#giftCardAmountDropdown").jScrollPane();
                $("#giftCardAmount").jScrollPane();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                if (xhr.status == "409") {
                    location.href = "/account/create_account.jsp?error=409";
                } else {
                    location.href = "/common/serverError.jsp";
                }
            }
        });
        if (SelVal == "false") {
            $("#openElectronicPopup").show();
            $("#SaveChang").hide();
        } else {
            $("#openElectronicPopup").hide();
            $("#SaveChang").show();
        }
    });
    $(document).on("change", "#giftCardAmount",
    function(e) {
        var SelVal = $("#send_by_dropdown :selected").val();
        if (SelVal == "false") {
            $("#openElectronicPopup").show();
            $("#SaveChang").hide();
        } else {
            $("#openElectronicPopup").hide();
            $("#SaveChang").show();
        }
        var GiftCardSelVal = $("#giftCardAmount :selected").val();
        if (GiftCardSelVal == "other") {
            $("#SelectInput").show();
        } else {
            $("#SelectInput").hide();
            $("#SelectInput").val(GiftCardSelVal);
        }
    });
    $(document).on("click", "#CancelMailPopup",
    function(e) {
        e.preventDefault();
        $("#productQuickviewModal").dialog("close");
    });
    $("#imagesBoxThumbnails").find(".flexslider").flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 100,
        itemMargin: 2
    });
    $(document).on("click", ".shipping_instruction_popup",
    function(e) {
        e.preventDefault();
        e.stopPropagation();
        var link = $(this).attr("href");
        $.ajax({
            url: link,
            type: "POST",
            dataType: "html",
            success: function(data) {
                $("#shipping_instr_popup_container").html(data);
                $("#shipping_instr_popup_container").dialog({
                    autoOpen: false,
                    height: "auto",
                    width: "auto",
                    modal: true
                });
                $("#shipping_instr_popup_container").dialog("open");
            },
            error: function(xhr, ajaxOptions, thrownError) {
                if (xhr.status == "409") {
                    location.href = "/account/create_account.jsp?error=409";
                } else {
                    location.href = "/common/serverError.jsp";
                }
            }
        });
    });
    $(".tooltip").tooltipster({
        theme: ".my-custom-theme"
    });
    $("#closeFlyout").click(function() {
        $("#productDetailsFlyout").toggleClass("show", 200);
        $("#productDetailsFlyout").toggleClass("hide", 200);
    });
    $(document).on("mouseover", ".view-icon, .unfavorite-heart, .favorite-heart",
    function() {
        $(".share-links").css("display", "none");
        $(".share-links").removeClass("overActive");
    });
    $(document).on("mouseover", ".share-links",
    function() {
        $(".share-links").addClass("overActive");
        $("#productQuickviewModal").css("overflow", "visible");
        $(".fave-share-product a.share_pdp").css("overflow", "visible");
    });
    $(document).on("touchstart", ".view-icon, .unfavorite-heart, .favorite-heart",
    function() {
        $(".share-links").css("display", "none");
        $(".share-links").removeClass("overActive");
    });
    $(document).on("touchstart", ".share-links",
    function() {
        $(".share-links").addClass("overActive");
        $("#productQuickviewModal").css("overflow", "visible");
        $(".fave-share-product a.share_pdp").css("overflow", "visible");
    });
    $(document).on("mouseleave", ".share-links",
    function() {
        $(".share-links").hide("fade", 200);
        $(".share-links").removeClass("overActive");
        setTimeout(function() {
            if (!$(".share-links").hasClass("overActive")) {
                $(".share-links").hide();
                $(".share-links").removeClass("overActive");
                $("#productQuickviewModal").css("overflow", "hidden");
                $(".fave-share-product a.share_pdp").css("overflow", "hidden");
            }
        },
        500);
    });
    $(document).on("mouseover focusin", ".share-icon",
    function() {
        var tempObj = $(this).parent().find(".socialShareDetails");
        shareProductDetails(tempObj);
        $(this).next().show("fade", 500);
    });
    $(document).on("touchstart", ".share-icon",
    function() {
        var tempObj = $(this).parent().find(".socialShareDetails");
        shareProductDetails(tempObj);
        $(this).next().show("fade", 500);
    });
    $(document).on("mouseover", "#share_pdp_id",
    function() {
        var tempObj = $(this).parent().find(".socialShareDetails");
        shareProductDetails(tempObj);
        setTimeout(function() {
            $(".fave-share-product .hero-tooltip-content1").show();
        },
        500);
    });
    $("[class*='share']").mouseleave(function(a) {
        setTimeout(function() {
            if (!$(".share-links").hasClass("overActive")) {
                $(".share-links").hide();
                $(".share-links").removeClass("overActive");
            }
        },
        200);
    });
    $("body").bind("touchstart",
    function(e) {
        if ($(e.target).closest(".share-icon").length == 0) {
            if ($(e.target).closest(".share-links").length == 0) {
                setTimeout(function() {
                    if (!$(".share-links").hasClass("overActive")) {
                        $(".share-links").hide();
                        $(".share-links").removeClass("overActive");
                    }
                },
                200);
            }
        }
    });
    $("#productColors ul.group li").on({
        mouseover: function() {
            $("#productColors ul.group li").removeClass("selected_new");
            $(this).addClass("selected_new");
        },
        mouseleave: function() {
            $("#productColors ul.group li").removeClass("selected_new");
        }
    });
    $("#productDetailsRightSidebar #productSize,#productDetailsRightSidebar #productQty").on("change",
    function() {
        if (($("#productQty").val() == 0) && ($("#productSize").val() == 0)) {
            $("#productDetailsPageContainer #addToBag").attr("disabled", "disabled");
        } else {
            $("#productDetailsPageContainer #addToBag").removeAttr("disabled");
        }
    }); (function($) {
        $("#trendsAndCategoriesNav").height($("#categoryGrid, #productGrids").height());
    })(jQuery);
    $(window).resize(function() {
        $("#trendsAndCategoriesNav").height($("#categoryGrid, #productGrids").height());
    });
    if (!$("nav#categories li.subcategory a").find("span").hasClass("drop-down")) {
        $("nav#categories li.subcategory").find("ul.subCategory_submenu").prev("a").append("<span class='drop-down'></span>");
    }
    if ($("nav#categories li.subcategory > a").siblings("ul").hasClass("selected")) {
        $("nav#categories li.subcategory > a").siblings("ul.subCategory_submenu.selected").parent("li").find(".drop-down").addClass("dropdown-leftnav-arrow").removeClass("drop-down");
    }
    $("nav#categories li.subcategory > a span").click(function(e) {
        e.preventDefault();
        var $that = $(this);
        $that.parent().siblings("ul").slideToggle("slow",
        function() {
            if ($that.hasClass("dropdown-leftnav-up-arrow")) {
                $that.removeClass("dropdown-leftnav-up-arrow");
                $that.addClass("dropdown-leftnav-arrow");
            } else {
                $that.removeClass("dropdown-leftnav-arrow");
                $that.addClass("dropdown-leftnav-up-arrow");
            }
        });
    });
    toolTip(".fav-icon", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".share-icon", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".view-icon", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".view-icon-outfit", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".view-icon-outfit1", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".fave", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".view", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".share", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".view_icon", "right-15 center", "right-15 center", "light-arrow-right");
    toolTip(".fave-share-product .fave", "right-15 top+12", "center bottom", "light-arrow-top");
    toolTip(".unfavorite-heart", "right-15 top-15", "center", "light-arrow-right");
    toolTip(".favorite-heart", "right-15 top-15", "center", "light-arrow-right");
    $(document).on("click", ".fave",
    function(e) {
        e.preventDefault();
        if ($(this).hasClass("favorited")) {
            $(this).removeClass("favorited");
            $(this).on("mouseleave",
            function() {
                $(this).attr("title", "Add to Favorites");
            });
        } else {
            $(this).addClass("favorited");
            $(this).on("mouseleave",
            function() {
                $(this).attr("title", "Remove from Favorites");
            });
        }
    });
    $(".fav-icon").on("click",
    function(e) {
        e.preventDefault();
        if ($(this).hasClass("favorited")) {
            $(this).removeClass("favorited");
            $(this).on("mouseleave",
            function() {
                $(this).attr("title", "Add to Favorites");
            });
        } else {
            $(this).addClass("favorited");
            $(this).on("mouseleave",
            function() {
                $(this).attr("title", "Remove from Favorites");
            });
        }
    });
    $(".custom-chkbox").on("click",
    function(e) {
        $(this).toggleClass("custom-chkbox-select");
    });
    $(".custom-chkbox").bind("touchstart",
    function(e) {
        $(this).toggleClass("custom-chkbox-select");
        location.href = $(this).attr("href");
    });
    $(".img-fav a").on("click",
    function(e) {
        e.preventDefault();
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            $(this).on("mouseleave",
            function() {
                $(this).attr("title", "Add to Favorites");
            });
        } else {
            $(this).addClass("active");
            $(this).on("mouseleave",
            function() {
                $(this).attr("title", "Remove from Favorites");
            });
        }
    });
    $("#quickViewOtherOptions>*").on("click",
    function(e) {});
    $(".view-icon").on("click",
    function(e) {
        e.preventDefault();
        e.stopPropagation();
        QuickviewAjaxPopUP($(this), e);
    });
    $(".view-icon").on("touchstart",
    function(e) {
        e.preventDefault();
        e.stopPropagation();
        QuickviewAjaxPopUP($(this), e);
    });
    $(".hero-tooltip-container").mouseenter(function() {
        clearTimeout($(this).data("timeoutId"));
        $(this).find(".hero-tooltip-content").fadeIn("fast");
    }).mouseleave(function() {
        var hotspot = $(this);
        var timeoutId = setTimeout(function() {
            hotspot.find(".hero-tooltip-content").fadeOut("slow");
        },
        1650);
        hotspot.data("timeoutId", timeoutId);
    });
    $("#productDescriptionTab").tabs().show().removeAttr("tabindex").attr("tabindex", "32");
    $("#productDescriptionTab").find("a").removeAttr("tabindex").attr("tabindex", "32");
    $("#productDescription").jScrollPane();
    $("#productDescription").removeAttr("tabindex");
    $(".productDetailFullSizeImage_cont #productDetailFullSizeImage").attr("tabindex", "32");
    if ($("#productDetailFullSizeImage.gift-card-image").length) {
        $("#productDetailFullSizeImage.gift-card-image").attr("tabindex", "32");
        $("#send_by_dropdown_detail").attr("tabindex", "33");
        var selectSBVal = $("#send_by_dropdown_detail").attr("sb");
        var selectID = "sbHolder_" + selectSBVal;
        $("#" + selectID).attr("tabindex", "33");
        $("#giftCardAmountdetail").attr("tabindex", "34");
        selectSBVal = $("#giftCardAmountdetail").attr("sb");
        selectID = "sbHolder_" + selectSBVal;
        $("#" + selectID).attr("tabindex", "34");
        $("#SelectInputdetail").attr("tabindex", "35");
        $("#addGiftItemToBag").attr("tabindex", "35");
    }
    $("#breadcrumb [href]").each(function() {
        $(this).attr("tabindex", "24");
        $(this).focus(function() {
            $(this).mouseover();
        }).bind("focusout",
        function() {
            $(this).mouseleave();
        });
    }).bind("keydown",
    function(evt4) {
        if (evt4.keyCode == 13) {
            location.href = $(this).attr("href");
        }
    }).bind("mouseover",
    function(evt4) {
        $(this).css("border", "1px solid #AB9259");
    }).bind("mouseleave",
    function(evt4) {
        $(this).css("border", "none");
    });
    $("#prevNextPager [href]").each(function() {
        $(this).attr("tabindex", "24");
        $(this).focus(function() {
            $(this).mouseover();
        }).bind("focusout",
        function() {
            $(this).mouseleave();
        });
    }).bind("keydown",
    function(evt4) {
        if (evt4.keyCode == 13) {
            location.href = $(this).attr("href");
        }
    }).bind("mouseover",
    function(evt4) {
        $(this).css("border", "1px solid #AB9259");
    }).bind("mouseleave",
    function(evt4) {
        $(this).css("border", "none");
    });
    $("#productListItemDetails").jScrollPane();
    $(document).on("click", "ul.ui-tabs-nav li",
    function() {
        $("ul.tabs li").removeClass("active");
        $(".tab_content").hide();
        var activeTab = $(this).find("a").attr("href");
        $(activeTab).fadeIn().jScrollPane();
        return false;
    });
    $(".productQuickviewTabs").tabs();
    $("#activityFeeds").tabs();
    if ($("#productDetailsAlsoLike").length) {}
    if ($("#findInStore").length) {
        displayFindInStoreModal();
    }
    $(".searchStoresBtn").click(function(e) {
        e.preventDefault();
        var customerAddress = $(this).siblings(".locateInStoreAddressField").val();
        findInStore(customerAddress);
    });
    $("#giftCardSendByDropdown").change(function() {
        var giftCardSendByVal = $("#giftCardSendByDropdown option:selected").val();
        if (giftCardSendByVal === "email") {
            $("#giftCardMessage").dialog({
                autoOpen: true,
                modal: true,
                dialogClass: "no-close",
                closeText: "Close Window",
                draggable: false,
                resizable: false,
                width: 482,
                height: "auto",
                show: {
                    effect: "fade",
                    duration: 300
                },
                hide: {
                    effect: "fade",
                    duration: 300
                }
            });
        }
    });
    $("body").bind("touchstart",
    function(e) {
        if ($("#OuterFilterContain").css("display") != "none") {
            $("#OuterFilterContain").bind("touchstart",
            function(e) {
                return false;
            });
            setTimeout(function() {
                $("#Overlay-sort").remove();
            },
            1000);
        }
        if ($("#sortbydropdown-outer").css("display") != "none") {
            $("#sortbydropdown-outer").bind("touchstart",
            function(e) {
                return false;
            });
        }
    });
    $(".dialog-close-button, #closeGiftModal").click(function() {
        $("#giftCardMessage").dialog("close");
        $("#giftCardMessage").parent().appendTo($("#giftCardForm"));
    });
    var filterSortContainer = $("#filterSortContainer");
    var swatchOutline = $("div.swatch-outline");
    if ($("#filterDropdownContainer").outerHeight() > 269) {
        $("#filterDropdownContainer").jScrollPane({
            mouseWheelSpeed: 35
        });
        $("#OuterFilterContain").css({
            paddingBottom: "30px"
        });
    }
    var menu = $("#OuterFilterContain");
    var timeout = 0;
    var hovering = false;
    menu.hide();
    var isiPad = (navigator.userAgent.match(/iPad/i) != null);
    if (!isiPad) {
        $("#filterLabel").on("mouseenter",
        function() {
            hovering = true;
            filter();
            $(".dropdown-arrow").addClass("dropdown-up-arrow");
            setTimeout(function() {
                filterarrow();
                if ($("#toggleContentType span").length == 1) {
                    $(".plp_filter_align").css("top", "-6px");
                } else {
                    $(".plp_filter_align").css("top", "8px");
                }
            },
            1000);
        }).on("mouseleave",
        function() {
            hovering = false;
            resetHover();
            setTimeout(function() {
                filterarrow();
                if ($("#toggleContentType span").length == 1) {
                    $(".plp_filter_align").css("top", "-6px");
                } else {
                    $(".plp_filter_align").css("top", "8px");
                }
            },
            1000);
        });
    }
    $("#OuterFilterContain").on("mouseenter",
    function() {
        hovering = true;
        var filterColumnLength = "";
        if ($("#filterDropdownContainer").find(".jspPane").length) {
            filterColumnLength = $("#filterDropdownContainer").find(".jspPane").children("div").length;
        } else {
            filterColumnLength = $("#filterDropdownContainer").children("div").length;
        }
        if (filterColumnLength > 4) {
            $("#filterDropdownContainer").jScrollPane({
                mouseWheelSpeed: 35
            });
        }
        startTimeout();
    }).on("mouseleave",
    function() {
        hovering = false;
        resetHover();
        setTimeout(function() {
            $("#Overlay-sort").remove();
            filterarrow();
            if ($("#toggleContentType span").length == 1) {
                $(".plp_filter_align").css("top", "-6px");
            } else {
                $(".plp_filter_align").css("top", "8px");
            }
        },
        1000);
    });
    function startTimeout() {
        timeout = setTimeout(function() {
            closeMenu();
        },
        500);
    }
    function closeMenu() {
        if (!hovering) {
            $("#OuterFilterContain").stop(true, true).slideUp(400);
            $(".dropdown-arrow").toggleClass("dropdown-up-arrow");
            $("#Overlay-filter.blockOverlay").remove();
            $(".dropdown-arrow").addClass("down-filter-arrow");
        }
    }
    function resetHover() {
        hovering = false;
        startTimeout();
    }
    function sortarrow() {
        if ($("#sortbydropdown-outer").is(":visible")) {
            $(".plp_filter_align_sort").css("display", "block");
            $(".plp_filter_align").css("display", "none");
        } else {
            $(".plp_filter_align_sort").css("display", "none");
        }
    }
    function filterarrow() {
        if ($("#OuterFilterContain").is(":visible")) {
            $(".plp_filter_align").css("display", "block");
            $(".plp_filter_align_sort").css("display", "none");
        } else {
            $(".plp_filter_align").css("display", "none");
        }
    }
    var menu_sort = $("#sortbydropdown");
    var timeout_sort = 0;
    var hovering_sort = false;
    $("#sortByLabel").bind("touchstart",
    function() {
        if ($("#sortbydropdown-outer").is(":visible")) {
            resetHover_sort();
            setTimeout(function() {
                $("#Overlay-sort").remove();
            },
            1000);
        } else {
            hovering_sort = true;
            sort();
        }
    });
    $("#filterLabel").bind("touchstart",
    function() {
        if ($("#OuterFilterContain").is(":visible")) {
            resetHover();
        } else {
            hovering = true;
            filter();
        }
    });
    if (!isiPad) {
        $("#sortByLabel").on("mouseenter",
        function() {
            hovering_sort = true;
            sort();
            $(".dropdown-arrow-sort").addClass("dropdown-up-arrow-sort");
            setTimeout(function() {
                sortarrow();
                if ($("#toggleContentType span").length == 1) {
                    $(".plp_filter_align_sort").css("top", "-5px");
                } else {
                    $(".plp_filter_align_sort").css("top", "9px");
                }
            },
            1000);
        }).on("mouseleave",
        function() {
            resetHover_sort();
            setTimeout(function() {
                $("#Overlay-sort").remove();
                sortarrow();
                if ($("#toggleContentType span").length == 1) {
                    $(".plp_filter_align_sort").css("top", "-5px");
                } else {
                    $(".plp_filter_align_sort").css("top", "9px");
                }
            },
            1500);
        });
    }
    $("#sortbydropdown-outer").on("mouseenter",
    function() {
        hovering_sort = true;
        startTimeout_sort();
    }).on("mouseleave",
    function() {
        resetHover_sort();
        setTimeout(function() {
            sortarrow();
            if ($("#toggleContentType span").length == 1) {
                $(".plp_filter_align_sort").css("top", "-5px");
            } else {
                $(".plp_filter_align_sort").css("top", "9px");
            }
        },
        1000);
    });
    function startTimeout_sort() {
        timeout_sort = setTimeout(function() {
            closeMenu_sort();
        },
        1000);
    }
    function closeMenu_sort() {
        if (!hovering_sort) {
            $("#sortbydropdown-outer").stop(true, true).slideUp(400);
            $(".dropdown-arrow-sort").toggleClass("dropdown-up-arrow-sort");
            $("#Overlay-sort").remove();
            $(".dropdown-arrow-sort").addClass("down-sort-arrow");
        }
    }
    function resetHover_sort() {
        hovering_sort = false;
        startTimeout_sort();
    }
    function sort() {
        $("#sortbydropdown-outer").css({
            zIndex: "801"
        });
        $("#Overlay-filter .blockOverlay").remove();
        $("#OuterFilterContain").stop(true, true).slideUp(400);
        $("#sortbydropdown-outer").stop(true, true).slideDown(400);
        $(".dropdown-arrow-sort").toggleClass("dropdown-up-arrow-sort");
        if (timeout_sort > 0) {
            clearTimeout(timeout_sort);
        }
        var overlay = $('<div class="blockUI blockOverlay" id="Overlay-sort" ></div>');
        $("#categoryGrid").append(overlay);
        setTimeout(function() {
            if ($("#sortbydropdown-outer").is(":visible")) {
                $(".plp_filter_align_sort").css("display", "block");
                $(".plp_filter_align").css("display", "none");
            } else {
                $(".plp_filter_align_sort").css("display", "none");
            }
        });
        $(".dropdown-arrow-sort").removeClass("down-sort-arrow");
    }
    function filter() {
        $("#OuterFilterContain").css({
            top: "44px"
        });
        $("#OuterFilterContain").css({
            zIndex: "801"
        });
        $("#Overlay-sort").remove();
        $("#sortbydropdown-outer").stop(true, true).slideUp(400);
        $("#OuterFilterContain").stop(true, true).slideDown(400);
        $(".dropdown-arrow").toggleClass("dropdown-up-arrow");
        if (timeout > 0) {
            clearTimeout(timeout);
        }
        var overlay = $('<div class="blockUI blockOverlay" id="Overlay-filter" ></div>');
        $("#categoryGrid").append(overlay);
        setTimeout(function() {
            if ($("#OuterFilterContain").is(":visible")) {
                $(".plp_filter_align").css("display", "block");
                $(".plp_filter_align_sort").css("display", "none");
            } else {
                $(".plp_filter_align").css("display", "none");
            }
        });
        var filterLeft = [];
        var filterLeftObj = [];
        $("#filterDropdownContainer #priceColumn").each(function() {
            filterLeft.push($(this).offset().left);
            filterLeftObj.push(this);
        });
        var maxValue = Math.max.apply(this, filterLeft);
        var index = $.inArray(maxValue, filterLeft);
        var filterHeight = [];
        $("#OuterFilterContain #priceColumn").each(function(i) {
            filterHeight.push($(this).innerHeight());
        });
        $("#OuterFilterContain #colorColumn").each(function(i) {
            filterHeight.push($(this).innerHeight());
        });
        var tfilterHeight = Math.max.apply(this, filterHeight);
        $("#OuterFilterContain #priceColumn").each(function(i) {
            $(this).css({
                height: tfilterHeight
            });
        });
        $("#OuterFilterContain #colorColumn").each(function(i) {
            $(this).css({
                height: tfilterHeight
            });
        });
        $(".dropdown-arrow").removeClass("down-filter-arrow");
    }
    $(".RedirectSort").on("click",
    function() {
        window.location = $(this).attr("href");
    });
    $(".RedirectSort").bind("touchstart",
    function() {
        window.location = $(this).attr("href");
    });
    if ($("#productQuickviewModal").length) {}
    if ($("#largeProductCarousel").length) {
        $("#largeProductCarousel").carouFredSel({
            circular: false,
            infinite: false,
            keyshort: false,
            height: 886,
            width: "100%",
            items: {
                start: 0,
                visible: 3,
                minimum: 3,
                width: 549,
                height: 924
            },
            scroll: {
                items: 1,
                duration: 300
            },
            swipe: {
                onTouch: true
            },
            auto: false,
            prev: {
                button: ".lg-grid-prev",
                key: "left"
            },
            next: {
                button: ".lg-grid-next",
                key: "right"
            }
        });
        var starterProductItems = $("#largeProductCarousel").triggerHandler("currentVisible");
        $(starterProductItems).css("opacity", 0.4);
        $(starterProductItems[1]).css("opacity", 1);
        var actionIcons = $("#largeProductCarousel li div.action-icons");
        var largeDetails = $("#largeProductCarousel div.large-grid-details");
        $(actionIcons).css("visibility", "hidden");
        $(largeDetails).css("visibility", "hidden");
        $(actionIcons[1]).css("visibility", "visible");
        $(largeDetails[1]).css("visibility", "visible");
        $(starterProductItems[1]).find("div.action-icons").css("visibility", "visible");
        $(starterProductItems[1]).find("div.large-grid-details").css("visibility", "visible");
        if ($(starterProductItems[1]).hasClass("onlyOneProd")) {
            $("#productGrids").addClass("onlyOneProd-main");
            if ($("#productGrids").hasClass("onlyOneProd-main")) {
                $("#productGrids.onlyOneProd-main").find(".lg-grid-prev").css("display", "none");
                $("#productGrids.onlyOneProd-main").find(".lg-grid-next").css("display", "none");
            }
        }
        $(".lg-grid-prev").hide();
        $(".lg-grid-next").on("click",
        function() {
            console.log("clicked");
            $("#largeProductCarousel").trigger("pause", true);
            $(".lg-grid-prev").show();
            var currentItems = $("#largeProductCarousel").triggerHandler("currentVisible");
            $("#largeProductCarousel li").css({
                opacity: 0.4,
                "z-index": 0,
                background: "transparent"
            });
            $(currentItems[2]).css({
                opacity: 1,
                "z-index": 5,
                background: "#fff"
            });
            $(actionIcons).css("visibility", "hidden");
            $(largeDetails).css("visibility", "hidden");
            $(currentItems[1]).find("div.action-icons").css("visibility", "hidden");
            $(currentItems[2]).find("div.action-icons").css("visibility", "visible");
            $(currentItems[2]).find("div.large-grid-details").css("visibility", "visible");
            if ($(currentItems[2]).hasClass("lastItem")) {
                $(".lg-grid-next").hide();
            }
            if ($(currentItems[2]).hasClass("insertajax")) {
                $("#cP").val(parseInt($("#cP").val()) + 1);
                var currentPage = $("#cP").val();
                var totRecsPerPage = $("#nrpp").val();
                var queryString = $("#queryParam").val();
                var totalRecord = parseInt($("#totalRecord").val());
                var navValue = $("#navValue").val();
                var NttValue = $("#NttValue").val();
                var nextStartIdx = currentPage * totRecsPerPage;
                var vs = $("#viewSize").val();
                console.log("currentPage=" + currentPage);
                console.log("totRecsPerPage=" + totRecsPerPage);
                console.log("nextStartIdx=" + nextStartIdx);
                console.log("navValue=" + navValue);
                console.log("NttValue=" + NttValue);
                $.ajax({
                    url: "/category/ajaxLoading.jsp?No=" + nextStartIdx + "&N=" + navValue + "&Ntt=" + NttValue + "&" + queryString,
                    type: "GET",
                    dataType: "html",
                    success: function(data) {
                        if ($.trim(data) != "") {
                            $("#largeProductCarousel li").removeClass("insertajax");
                            $(".dummyTXT").html($.trim(data));
                            $("#largeOutfitCarousel li").removeClass("insertajax");
                            var len = $(".dummyTXT").find(".category-large-container").length;
                            for (var k = 0; k < len; k++) {
                                var datToInser = $(".dummyTXT").find(".category-large-container")[k].outerHTML;
                                var datPos = parseInt(k) + 3;
                                $("#largeProductCarousel").trigger("insertItem", [datToInser, datPos, false]);
                            }
                            $("#largeProductCarousel").trigger("resume", true);
                        } else {
                            $(".lg-grid-next").addClass("disabled");
                        }
                        $("select").selectbox();
                    }
                });
            } else {
                $("#largeProductCarousel").trigger("resume", true);
            }
        });
        $(".lg-grid-prev").on("click",
        function() {
            $(".lg-grid-next").show();
            var currentItems = $("#largeProductCarousel").triggerHandler("currentVisible");
            $("#largeProductCarousel li").css({
                opacity: 0.4,
                "z-index": 0,
                background: "transparent"
            });
            $(currentItems[1]).css({
                opacity: 1,
                "z-index": 5,
                background: "#fff"
            });
            $(actionIcons).css("visibility", "hidden");
            $(largeDetails).css("visibility", "hidden");
            $(currentItems[1]).find("div.action-icons").css("visibility", "visible");
            $(currentItems[1]).find("div.large-grid-details").css("visibility", "visible");
            if ($(currentItems[1]).hasClass("firstItem")) {
                $(".lg-grid-prev").hide();
            }
        });
        $("#largeProductCarousel").swipe({
            swipeLeft: function(e) {
                $(".lg-grid-next").trigger("click");
                var currentItems = $("#largeProductCarousel").triggerHandler("currentVisible");
                if ($(currentItems[2]).hasClass("lastItem")) {
                    $(".lg-grid-next").hide();
                    e.stopPropagation();
                }
            },
            swipeRight: function() {
                $(".lg-grid-prev").trigger("click");
            }
        });
        function largeviewTabindex() {
            var i = 32;
            $("#largeProductCarousel li").each(function(i) {
                $(this).find("img.category-large-image").attr("tabindex", 30 + i);
                $(this).find("img.category-large-image").on("keydown",
                function() {
                    if (event.keyCode == 13) {
                        $(this).trigger("click");
                    }
                });
                i = i + 1;
                $(this).find(".large-grid-details").find(".display_price PriceRed").attr("tabindex", 30 + i);
                $(this).find(".large-grid-details").find(".display_price PriceRed").on("keydown",
                function() {
                    if (event.keyCode == 13) {
                        $(this).trigger("click");
                    }
                });
                i = i + 1;
                $(this).find(".largeContentSelect").find("select").selectbox("detach");
                $(this).find(".largeContentSelect").find("select").selectbox();
                $(this).find(".largeContentSelect").find(".sbHolder:eq(0)").removeAttr("tab-index");
                $(this).find(".largeContentSelect").find(".sbHolder:eq(1)").removeAttr("tab-index");
                i = i + 1;
                $(this).find(".largeContentSelect").find(".sbHolder:eq(0)").removeAttr("tab-index").attr("tabindex", 30 + i);
                i = i + 1;
                $(this).find(".largeContentSelect").find(".sbHolder:eq(1)").removeAttr("tab-index").attr("tabindex", 30 + i);
                $(this).find(".largeContentSelect").find(".sbToggle,.sbSelector").removeAttr("tab-index").removeAttr("tabindex");
                $(this).find(".largeContentSelect").find(".sbHolder:eq(0)").on("keydown",
                function() {
                    if (event.keyCode == 13) {
                        $(this).children(".sbSelector").trigger("click");
                        $(this).focus();
                    }
                    if (event.keyCode == 9) {
                        $(this).next().focus();
                    }
                });
                $(this).find(".largeContentSelect").find(".sbHolder:eq(1)").on("keydown",
                function() {
                    if (event.keyCode == 13) {
                        $(this).children(".sbSelector:eq(1)").trigger("click");
                        $(this).focus();
                    }
                    if (event.keyCode == 9) {
                        $(this).siblings(".add-to-bag-shine #addToBag").focus();
                    }
                });
                i = i + 1;
                $(this).find(".largeContentSelect").find(".add-to-bag-shine #addToBag").on("focus",
                function() {
                    $(this).css("border", "5px solid #AB9259");
                }).on("focusout",
                function() {
                    $(this).css("border", "none");
                });
                i = i + 1;
                $(this).find(".large-product-view-details").find(".view-details-icon,a").attr("tabindex", 30 + i);
                $(this).find(".largeContentSelect");
                i++;
            });
            $(".action-icons .hero-tooltip-content1 .share-email").each(function() {
                $(this).on("keydown",
                function() {
                    if (event.keyCode == 9) {
                        console.log("clicked");
                    }
                });
            });
        }
    }
    $(document).on("click", ".share-links .share-email", sharePopup);
    $(document).on("focus", ".productQuickviewTabs ul li,#productDescriptionTab ul li",
    function() {
        $(".jspDrag").attr("tabindex", "32");
    });
});
function largeViewlistingindex() {
    $("#productGrids").find(".lg-grid-next").each(function() {
        if ($(this).is(":visible")) {
            $(this).attr("tabindex", "32");
        }
    });
    $("#largeProductCarousel").find(".category-large-container").removeAttr("tabindex");
    $("#largeProductCarousel").find(".category-large-container a").removeAttr("tabindex");
    $("#largeProductCarousel").find(".category-large-container div").removeAttr("tabindex");
    $("#largeProductCarousel").find(".category-large-container li").removeAttr("tabindex");
    $("#largeProductCarousel").find(".category-large-container button").removeAttr("tabindex");
    $("#productGrids").find(".lg-grid-next,.lg-grid-prev").keypress(function(b) {
        if (b.keyCode == 13) {
            $(this).trigger("click");
            setTimeout(function() {
                $("#largeProductCarousel").find(".category-large-container").removeAttr("tabindex");
                $("#largeProductCarousel").find(".category-large-container a").removeAttr("tabindex");
                $("#largeProductCarousel").find(".category-large-container li").removeAttr("tabindex");
                $("#largeProductCarousel").find(".category-large-container button").removeAttr("tabindex");
                $("#largeProductCarousel").find(".category-large-container iframe").removeAttr("tabindex");
                $("#largeProductCarousel").find(".category-large-container").each(function() {
                    if ($(this).css("opacity") == 1) {
                        $(this).attr("tabindex", "31");
                        $(this).find("a").each(function() {
                            $(this).attr("tabindex", "31");
                        });
                        $(this).find(".largeContentSelect").find("a").removeAttr("tabindex");
                        i = 32;
                        $(this).find(".sbHolder").each(function() {
                            $(this).attr("tabindex", i);
                            i++;
                        });
                        $(this).find("#addToBag").attr("tabindex", i);
                        $(this).find(".large-product-view-details a").removeAttr("tabindex").attr("tabindex", i + 1);
                        $("#productGrids").find(".lg-grid-next").attr("tabindex", i + 2);
                        if ($("#productGrids").find(".lg-grid-prev").is(":visible")) {
                            $("#productGrids").find(".lg-grid-prev").attr("tabindex", "30");
                        }
                        $(this).focus();
                    }
                });
                $("#productGrids").find(".lg-grid-prev").removeAttr("tabindex");
                $("#productGrids").find(".lg-grid-prev").each(function() {
                    if ($(this).is(":visible")) {
                        $(this).attr("tabindex", "30");
                    }
                });
            },
            200);
            b.preventDefault();
        }
    });
    $("#largeProductCarousel").find(".share-icon").focus(function() {
        $(this).trigger("mouseenter");
        setTimeout(function() {
            $("#largeProductCarousel").find(".hero-tooltip-content1").find("iframe").each(function() {
                $(this).attr("tabindex", "31");
            });
            $("#largeProductCarousel").find(".hero-tooltip-content1 a.pin-it-buttona img,.hero-tooltip-content1 table tr td a").attr("tabindex", "31");
            if ($("#largeProductCarousel").find(".hero-tooltip-content1 .share-email").length > 0) {
                $("#largeProductCarousel").find(".hero-tooltip-content1 .share-email").attr("tabindex", "31");
            }
        },
        3000);
    });
    setTimeout(function() {
        var b;
        if ($("#largeProductCarousel").find(".firstItem").length != 0) {
            b = $("#largeProductCarousel").find(".firstItem");
            largeviewlistTabindex(b);
        }
        if ($("#largeProductCarousel").find(".onlyOneProd").length != 0) {
            b = $("#largeProductCarousel").find(".onlyOneProd");
            largeviewlistTabindex(b);
        }
    },
    700);
}
function largeviewlistTabindex(b) {
    if (b.css("opacity") == 1) {
        b.attr("tabindex", "31");
        b.find("a").each(function() {
            $(this).attr("tabindex", "31");
        });
        b.find(".largeContentSelect").find("a").removeAttr("tabindex");
        i = 32;
        b.find(".sbHolder").each(function() {
            $(this).attr("tabindex", i);
            i++;
        });
        b.find("#addToBag").attr("tabindex", i);
        b.find(".large-product-view-details a").removeAttr("tabindex").attr("tabindex", i + 1);
        $("#productGrids").find(".lg-grid-next").attr("tabindex", i + 2);
    }
}
function toolTip(b, e, c, d) {
    $(b).tooltip({
        position: {
            my: e,
            at: c
        },
        tooltipClass: d,
        collision: "none"
    });
}
function swatchColorSelected() {
    $("#productColors ul.group li").on({
        mouseover: function() {
            $("#productColors ul.group li").removeClass("selected_new");
            $(this).addClass("selected_new");
        },
        mouseleave: function() {
            $("#productColors ul.group li").removeClass("selected_new");
        }
    });
}
function mightAlsoLikePositioning() {
    var e = $("#productDetailsAlsoLike"),
    d = $(e).offset(),
    c = $(window).height(),
    b = c - d.top - 32;
    if (b > 0) {
        $(e).css({
            "margin-top": b
        });
    }
    $("#productDetailsAlsoLike h2").click(function(f) {
        f.preventDefault();
        if ($(e).hasClass("show")) {
            $("html,body").animate({
                scrollTop: -d.top
            },
            500).removeClass("show");
            $(e).removeClass("show").addClass("hide");
        } else {
            $("html,body").animate({
                scrollTop: d.top
            },
            500);
            $(e).removeClass("hide").addClass("show");
        }
    });
}
function displayFindInStoreModal() {
    var c = $("#findInStore a"),
    b = $("#findInStoreModal");
    $(c).click(function(d) {
        d.stopPropagation();
        $(b).toggleClass("show");
    });
    $(document).on("click",
    function(d) {
        if ($(d.target).closest(b).length === 0) {
            $(b).removeClass("show");
        }
    });
    $(document).on("keydown",
    function(d) {
        if (d.keyCode === 27) {
            $(b).removeClass("show");
        }
    });
    $(".dialog-close-button").click(function(d) {
        $(b).removeClass("show");
    });
}
function findInStore(c) {
    var b = new google.maps.Geocoder();
    b.geocode({
        address: c
    },
    function(h, e) {
        if (e == google.maps.GeocoderStatus.OK) {
            var j = h[0].geometry.location,
            g = document.getElementById("locateInStoreProductId").value,
            k = document.getElementById("locateInStoreSelectedColor").value;
            var f = "?lat=" + h[0].geometry.location.lat() + "&lng=" + h[0].geometry.location.lng() + "&skuId=" + g + "&color=" + k;
            if ($("#findInStoreResultsModal").length) {
                $("#findInStoreResultsModal").load("/store/pdp/includes/find_store_data.jsp" + f,
                function() {});
            } else {
                var d = $('<div id="findInStoreResultsModal"></div>');
                $(d).dialog({
                    autoOpen: false,
                    modal: true,
                    closeOnEscape: true,
                    closeText: "Close Window",
                    dialogClass: "no-close",
                    draggable: false,
                    resizable: false,
                    height: "auto",
                    width: 600,
                    show: {
                        effect: "fade",
                        duration: 300
                    },
                    hide: {
                        effect: "fade",
                        duration: 300
                    }
                });
                $(d).dialog("open");
                $(d).load("/store/pdp/includes/find_store_data.jsp" + f);
            }
            console.log(f);
        } else {
            console.log("Geocode was not successful for the following reason: " + e);
        }
    });
}
function productQuickviewTabs() {
    $("#productQuickviewTabs").tabs();
}
$(".dialog-close-button").click(function() {
    $("#outfitModal").dialog("close");
});
function QuickviewAjaxPopUP(d, c) {
    if (!d.parents("div").is("#categoryGrid")) {
        c.preventDefault();
        c.stopPropagation();
        var b = d.attr("href");
        noajaxloader = true;
        productadding = true;
        $.ajax({
            url: b,
            type: "POST",
            dataType: "html",
            success: function(f) {
                var e = (navigator.userAgent.match(/iPad/i) != null);
                if (e) {
                    $(window).on("orientationchange",
                    function(g) {
                        $("#productQuickviewModal").dialog("option", "position", "center");
                    });
                }
                $("#productQuickviewModal").html(f);
                $("#productQuickviewModal").dialog({
                    autoOpen: false,
                    resizable: false,
                    height: "auto",
                    width: 770,
                    modal: true,
                    position: "center",
                    open: function() {
                        setTimeout(function() {
                            qvTabindex();
                        },
                        100);
                    },
                    close: function(h, j) {
                        if ($("#favoritedItemsContainer").length) {
                            var g = "/account/includes/favorites_include.jsp";
                            $.ajax({
                                url: g,
                                type: "POST",
                                dataType: "html",
                                success: function(k) {
                                    $("#FavoritesRefresh").replaceWith(k);
                                    setTimeout(function() {
                                        resetAccountHeight();
                                    },
                                    100);
                                }
                            });
                        }
                    }
                });
                noajaxloader = false;
                productadding = false;
                toolTip(".favorite-heart", "right-15 top-15", "center", "light-arrow-right");
                toolTip(".unfavorite-heart", "right-15 top-15", "center", "light-arrow-right");
                $(".swatch-container").find("li a.tooltip, li a img.tooltip, li img.tooltip").tooltipster({
                    theme: ".my-custom-theme"
                });
                $("select").selectbox();
                $("div#quickViewOtherOptions .product-quickview-share   .quickview-share").mouseover(function() {
                    console.log("qv_share");
                    var g = $(this).parent().find(".socialShareDetails");
                    shareProductDetails(g);
                    $(".product-quickview-share .hero-tooltip-content1").css("display", "block");
                });
                $("div#quickViewOtherOptions .product-quickview-share").mouseleave(function() {
                    setTimeout(function() {
                        if (!$(".share-links").hasClass("overActive")) {
                            $(".share-links").hide("fade", 500);
                        }
                    },
                    500);
                });
                $(".share-links").mouseover(function() {
                    $(".share-links").addClass("overActive");
                });
                $(".share-links").mouseleave(function() {
                    $(".share-links").hide("fade", 500);
                    $(".share-links").removeClass("overActive");
                });
                swatchColorSelected();
                $(".share-links .share-email").unbind("click", sharePopup).bind("click", sharePopup);
                setTimeout(function() {
                    $("#productQuickviewModal").dialog("open");
                },
                50);
                if (($("input#catalogRefId").val() == "") || ($("input#catalogRefId").val() == undefined)) {
                    $(".tooltip-store-popup").tooltipster({
                        trigger: "click",
                        theme: ".my-custom-theme"
                    });
                } else {
                    $(".tooltip-store-popup-ie9").hide();
                    $("#find-store-inquickview").tooltipster("destroy");
                    $("#find-store-inquickview").unbind("click", findStorePop).bind("click", findStorePop);
                }
                setTimeout(function() {
                    $("#imagesBox").trigger("focus");
                    $(".productQuickviewTabs").tabs().find("li").removeAttr("tabindex").attr("tabindex", "149");
                    $("#quickViewDesc").jScrollPane();
                    $(".productQuickviewTabs").tabs().find("a").removeAttr("tabindex");
                    $("#quickViewDesc").removeAttr("tabindex");
                    $("#quickViewDesc").find(".jspContainer").css("width", "415px");
                    $("#quickViewDesc").find(".jspPane").css("width", "400px");
                    $("#quickViewDetails").jScrollPane();
                    $("#quickViewDetails").find(".jspContainer").css("width", "415px");
                    $("#quickViewDetails").find(".jspPane").css("width", "400px");
                    $("#quickViewDetails").jScrollPane();
                    $("#quickViewSize").jScrollPane();
                },
                200);
                checkInventory();
            },
            error: function(g, e, f) {
                if (g.status == "409") {
                    location.href = "/account/create_account.jsp?error=409";
                } else {
                    location.href = "/common/serverError.jsp";
                }
            }
        });
    }
}
function qvTabindex() {
    $(".productQuickviewTabs").tabs().find("li").removeAttr("tabindex").attr("tabindex", "149");
    $("#quickViewDesc").jScrollPane();
    $("#quickViewDesc").removeAttr("tabindex").attr("tabindex", "32");
    $(".productQuickviewTabs").tabs().find("a").removeAttr("tabindex");
    $("#quickViewDesc").removeAttr("tabindex");
    var c = 150;
    if ($("#productQuickviewSwatchBox img").length > 0) {
        $("#productQuickviewSwatchBox img").each(function() {
            $(this).attr("tabindex", c);
            $(this).on("keydown",
            function() {
                if (event.keyCode == 13) {
                    $(this).trigger("click");
                }
                c = c + 1;
            });
            c = c + 1;
        });
    }
    if ($("#editProductSize").find(".sbHolder").length > 0) {
        $("#editProductSize").find(".sbHolder").removeAttr("tab-index").attr("tabindex", c);
        $("#editProductSize").find(".sbToggle,.sbSelector").removeAttr("tab-index").removeAttr("tabindex");
        $("#editProductSize").find(".sbHolder").on("focus",
        function() {
            if (event.keyCode == 13) {}
        });
        c = c + 1;
    }
    if ($("#editProductQty").find(".sbHolder").length > 0) {
        $("#editProductQty").find(".sbHolder").removeAttr("tab-index").attr("tabindex", c);
        $("#editProductQty").find(".sbToggle,.sbSelector").removeAttr("tab-index").removeAttr("tabindex");
        $("#editProductQty").find(".sbHolder").on("keydown",
        function() {
            if (event.keyCode == 13) {
                $(this).children(".sbSelector").trigger("click");
                $(this).focus();
            }
        });
        c = c + 1;
    }
    if ($(".mk_size_guide_cont a").length > 0) {
        $(".mk_size_guide_cont a").attr("tabindex", c);
        $(".mk_size_guide_cont a").on("focus",
        function() {
            $(this).css("border", "1px solid #AB9259");
        }).on("focusout",
        function() {
            $(this).css("border", "none");
        }).bind("keydown",
        function() {
            if (event.keyCode == 13) {
                $(this).trigger("click");
                $(this).trigger("focus");
            }
        });
        c = c + 1;
    }
    $("#detailsBox").find("#updateBag_Cart").attr("tabindex", c);
    $("#detailsBox").find("#updateBag_Cart").each(function() {
        if ($(this).is(":visible")) {}
    });
    $("#detailsBox").find("#resetForm").attr("tabindex", c + 1);
    $("#detailsBox").find("#resetForm").each(function() {
        if ($("#resetForm").is(":visible")) {}
    });
    $("#detailsBox").find("#editProdOtherOptions a").attr("tabindex", c + 1);
    $("#detailsBox").find("#editProdOtherOptions a").each(function() {
        if ($(this).is(":visible")) {}
    });
    $("#detailsBox").on("mousemove",
    function() {
        if ($("#quick-view-carousel-wrapper .s7thumb").length) {
            var d = 152;
            $("#detailsBox").off("mousemove");
        }
    });
    $(document).on("keydown", "#quick-view-carousel-wrapper .s7thumb",
    function(d) {
        if (d.keyCode === 13) {
            $(this)[0].click();
        }
    });
    $("#updateBag_Cart").keypress(function(d) {
        if (d.keyCode == 13) {
            $("#updateBag_Cart").trigger("click");
        }
    });
    $("#resetForm").keypress(function(d) {
        if (d.keyCode == 13) {
            $("#resetForm").trigger("click");
        }
    });
    if ($("#detailsBox  .add-to-bag-shine #addToBag").length > 0) {
        $("#detailsBox  .add-to-bag-shine #addToBag").attr("tabindex", c);
        $(".add-to-bag-shine #addToBag").on("focus",
        function() {
            $(this).css("border", "5px solid #AB9259");
        }).on("focusout",
        function() {
            $(this).css("border", "none");
        });
        c = c + 1;
    }
    if ($("#quickViewOtherOptions .product-quickview-favorite a").length > 0) {
        $("#quickViewOtherOptions .product-quickview-favorite a").attr("tabindex", c).on("keydown",
        function() {
            if (event.keyCode == 13) {
                $(this).trigger("click");
            }
        });
        c = c + 1;
    }
    if ($("#quickViewOtherOptions .product-quickview-share .quickview-share").length > 0) {
        var b = c;
        $("#quickViewOtherOptions .product-quickview-share .quickview-share").attr("tabindex", b);
        $("#quickViewOtherOptions .product-quickview-share .quickview-share").on("focus",
        function() {
            $(this).trigger("mouseenter");
            if ($(".hero-tooltip-content1 .share_outfit").length > 0) {
                $(".hero-tooltip-content1 .share_outfit").attr("tabindex", b);
            }
            if ($(".hero-tooltip-content1 .share-email").length > 0) {
                $(".hero-tooltip-content1 .share-email").attr("tabindex", b);
            }
            setTimeout(function() {
                $(".hero-tooltip-content1 iframe").each(function() {
                    $(this).attr("tabindex", b);
                });
                $(".hero-tooltip-content1 a.pin-it-buttona img,.hero-tooltip-content1 table tr td a").attr("tabindex", b);
            },
            3000);
        });
        c = c + 1;
    }
    if ($("#quickViewOtherOptions .product-quickview-view-details  a").length > 0) {
        $("#quickViewOtherOptions .product-quickview-view-details  a").attr("tabindex", c).on("keydown",
        function() {
            if (event.keyCode == 13) {
                $(this).trigger("click");
            }
        });
        c = c + 1;
    }
    if ($("#quickViewOtherOptions .product-quickview-store-details a").length > 0) {
        $("#quickViewOtherOptions .product-quickview-store-details a").attr("tabindex", c).on("keydown",
        function() {
            if (event.keyCode == 13) {
                $(this).trigger("mouseover");
                $(this).trigger("click");
            }
        });
        c = c + 1;
    }
}
function outfitqvTabindex() {
    console.log("outfitqvTabindex");
    var c = 32;
    if ($("div#imagesBox").length > 0) {
        $("div#imagesBox").find("#imagesBox_flyout .s7staticimage").attr("tabindex", "148");
        $("div#imagesBox").removeAttr("tabindex").attr("tabindex", c);
        c = c + 1;
    }
    if ($("div#detailsBox a.detailsline").length > 0) {
        $("div#detailsBox a.detailsline").removeAttr("tabindex").attr("tabindex", c);
        $("div#detailsBox a.detailsline").on("keydown",
        function() {
            var d = $(this).attr("href");
            if (event.keyCode == 13) {
                location.href = d;
            }
        });
        c = c + 1;
    }
    if ($("div.detail_container1").length > 0) {
        $("div.detail_container1").each(function() {
            $(this).attr("tabindex", c);
            c = c + 1;
            if ($(this).find("#collection-name").find(".collection-img a img").length > 0) {
                $(this).find("#collection-name").find(".collection-img a img").attr("tabindex", c);
                $(this).find("#collection-name").find(".collection-img a img").on("keydown",
                function() {
                    if (event.keyCode == 13) {
                        $(this).trigger("click");
                    }
                });
                c = c + 1;
            }
            if ($(this).find("#productColors li a img").length > 0) {
                $(this).find("#productColors li a img").each(function() {
                    $(this).attr("tabindex", c);
                    $(this).on("keydown",
                    function() {
                        if (event.keyCode == 13) {
                            $(this).trigger("click");
                        }
                    });
                    c = c + 1;
                });
            }
            if ($(this).find(".sizes-qnty").length > 0) {
                if ($(this).find(".sizes-qnty .mk_size_guide").length > 0) {
                    $(this).find(".sizes-qnty .mk_size_guide").attr("tabindex", c);
                    $(this).find(".sizes-qnty .mk_size_guide").on("focus",
                    function() {
                        $(this).css("border", "1px solid #AB9259");
                    }).on("focusout",
                    function() {
                        $(this).css("border", "none");
                    }).bind("keydown",
                    function() {
                        if (event.keyCode == 13) {
                            $(this).trigger("click");
                            $(this).trigger("focus");
                        }
                    });
                    c = c + 1;
                }
                if ($(this).find(".sizes-qnty").find(".sbHolder").length > 0) {
                    $(this).find(".sizes-qnty").find(".sbHolder").removeAttr("tab-index").attr("tabindex", c);
                    $(this).find(".sizes-qnty").find(".sbToggle,.sbSelector").removeAttr("tab-index").removeAttr("tabindex");
                    $(this).find(".sizes-qnty").find(".sbHolder").on("keydown",
                    function() {
                        if (event.keyCode == 13) {
                            $(this).children(".sbSelector").trigger("click");
                            $(this).focus();
                        }
                        if (event.keyCode == 9) {
                            $(this).parent(".sizes-qnty").siblings(".productQuantifier").find(".sbHolder").focus();
                        }
                    });
                    c = c + 1;
                }
            }
            if ($(this).find(".productQuantifier").find(".sbHolder").length > 0) {
                $(this).find(".productQuantifier").find(".sbHolder").removeAttr("tab-index").attr("tabindex", c);
                $(this).find(".productQuantifier").find(".sbToggle,.sbSelector").removeAttr("tab-index").removeAttr("tabindex");
                $(this).find(".productQuantifier").find(".sbHolder").on("keydown",
                function() {
                    if (event.keyCode == 13) {
                        $(this).children(".sbSelector").trigger("click");
                        $(this).focus();
                    }
                    if (event.keyCode == 9) {
                        $(this).parent(".productQuantifier").parent(".sizes").parent(".details-size-qnty").find(".imgs a").focus();
                    }
                });
                c = c + 1;
            }
            if ($(this).find(".imgs a").length > 0) {
                $(this).find(".imgs a").removeAttr("tabindex").attr("tabindex", c);
                $(this).find(".imgs a").on("keydown",
                function() {
                    if (event.keyCode == 13) {
                        $(this).trigger("click");
                    }
                });
                c = c + 1;
            }
            if ($(this).find(".add-to-bag-shine #addToBag").length > 0) {
                $(this).find(".add-to-bag-shine #addToBag").removeAttr("tabindex").attr("tabindex", c);
                $(this).find(".add-to-bag-shine #addToBag").on("focus",
                function() {
                    $(this).css("border", "5px solid #AB9259");
                }).on("focusout",
                function() {
                    $(this).css("border", "none");
                });
                c = c + 1;
            }
        });
    }
    $("div.detail_container1").on("focus",
    function() {
        $(this).find("#collection-name").find(".collection-img a img").trigger("focus");
    });
    var b = c;
    if ($(".outfit-btn input.outfit_share").length > 0) {
        $(".outfit-btn input.outfit_share").removeAttr("tabindex").attr("tabindex", c);
        $(".outfit-btn input.outfit_share").on("keydown",
        function() {
            if (event.keyCode == 13) {
                $(this).trigger("click");
            }
        }).on("focus",
        function() {
            $(this).trigger("mouseenter");
            $(".hero-tooltip-content1 .share-email").attr("tabindex", b);
            setTimeout(function() {
                $(".hero-tooltip-content1 iframe").each(function() {
                    $(this).attr("tabindex", b);
                });
                $(".hero-tooltip-content1 a.pin-it-buttona img,.hero-tooltip-content1 table tr td a").attr("tabindex", b);
            },
            3000);
        }).on("focusout",
        function() {});
        c = c + 1;
    }
    if ($(".outfit-btn input.outfit_details").length > 0) {
        $(".outfit-btn input.outfit_details").removeAttr("tabindex").attr("tabindex", c);
        $(".outfit-btn input.outfit_details").on("keydown",
        function() {
            if (event.keyCode == 13) {
                location.href = $(this).attr("onclick").split("'")[1];
            }
        }).on("focus",
        function() {}).on("focusout",
        function() {
            $(this).css("border", "none");
        });
    }
}
$(".favorite-actions .view-icon, .action-icons .view-icon").on("click",
function(b) {
    b.preventDefault();
    QuickviewAjaxPopUP($(this), b);
});
$(".favorite-actions .view-icon, .action-icons .view-icon").bind("touchstart",
function(b) {
    b.preventDefault();
    QuickviewAjaxPopUP($(this), b);
});
$(document).on("click", ".favorite-actions .view-icon, .action-icons .view-icon, .moveToBagPopUp",
function(b) {
    productadding = true;
    b.preventDefault();
    QuickviewAjaxPopUP($(this), b);
});
$("div#productQuickviewModal .dialog-close-button, div#productQuickviewModal .alt-button").click(function() {
    $("#productQuickviewModal").dialog("close");
});
$("div#productQuickviewModal .dialog-close-button, div#productQuickviewModal .alt-button").on("touchstart",
function() {
    $("#productQuickviewModal").dialog("close");
});
$(document).on("click", "div#productQuickviewModal .dialog-close-button, div.Customize-close .alt-button,  div.Customize-close #CancelMailPopup",
function() {
    $(".Customize-close").dialog("close");
});
$("div#productQuickviewModal .dialog-close-button, div.Customize-close .alt-button,  div.Customize-close #CancelMailPopup").bind("touchstart",
function() {
    $(".Customize-close").dialog("close");
});
function outfitQuickviewAjaxPopUP(d, c) {
    c.preventDefault();
    c.stopPropagation();
    var b = d.attr("href");
    noajaxloader = true;
    productadding = true;
    $.ajax({
        url: b,
        type: "POST",
        dataType: "html",
        success: function(e) {
            $(".outfit-quickview").html(e);
            noajaxloader = false;
            productadding = false;
            $(".swatch-container").find("li a.tooltip, li a img.tooltip, li img.tooltip").tooltipster({
                theme: ".my-custom-theme"
            });
            $(".outfit-btn .outfit_share").mouseover(function() {
                var f = $(".outfit-quickview").offset();
                var h = $(this).offset();
                var g = $(this).parent().find(".socialShareDetails");
                shareProductDetails(g);
                if (h.top - f.top > 250) {
                    $(".hero-tooltip-content1").css("display", "block");
                    $(".outfit_quickview_popup .share-links").css("top", "-188px");
                    $(".share-popup-arrow").removeClass("share-popup-arrow").addClass("share-popup-arrow1");
                } else {
                    $(".hero-tooltip-content1").css("display", "block");
                    $(".outfit_quickview_popup .share-links").css("top", "0px");
                    $(".share-popup-arrow1").removeClass("share-popup-arrow1").addClass("share-popup-arrow");
                }
            });
            $(".outfit-btn .outfit_share").mouseleave(function() {
                setTimeout(function() {
                    if (!$(".share-links").hasClass("overActive")) {
                        $(".share-links").hide("fade", 500);
                    }
                },
                500);
            });
            $(".share-links").mouseover(function() {
                $(".share-links").addClass("overActive");
            });
            $(".share-links").mouseleave(function() {
                $(".share-links").hide("fade", 500);
                $(".share-links").removeClass("overActive");
            });
            $("select").selectbox();
            outfitQuickViewCheckInventory();
            $(".share-links .share-email").unbind("click", sharePopup).bind("click", sharePopup);
            toolTip(".img-fav", "right-15 center", "right-15 center", "light-arrow-right");
            $(".img-fav").on("click",
            function(f) {
                f.preventDefault();
                if ($(this).hasClass("favorited")) {
                    $(this).removeClass("favorited");
                    $(this).on("mouseleave",
                    function() {
                        $(this).attr("title", "Add to Favorites");
                    });
                } else {
                    $(this).addClass("favorited");
                    $(this).on("mouseleave",
                    function() {
                        $(this).attr("title", "Remove from Favorites");
                    });
                }
            });
            $(".outfit-quickview").dialog({
                autoOpen: false,
                resizable: false,
                height: "auto",
                width: 770,
                modal: true
            });
            setTimeout(function() {
                $(".outfit-quickview").dialog("open");
                $(".products-descbox").jScrollPane();
                outfitqvTabindex();
                if (($(".outfit-quickview .outfit_quickview_popup #detailsBox .products-descbox .jspContainer .jspPane").children().length) == 0) {
                    $(".products-descbox").css("height", 80 + "px");
                    $(".share-popup-arrow").css("top", 20 + "px");
                }
            },
            50);
        },
        error: function(g, e, f) {
            if (g.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
    outfitqvTabindex();
}
$(document).on("click", ".outfit_container .view-icon-outfit, .outfit_container .view_icon",
function(b) {
    b.preventDefault();
    outfitQuickviewAjaxPopUP($(this), b);
});
$(".outfit-quickview").on("click", ".dialog-close-button-outfit",
function() {
    $(".outfit-quickview").dialog("close");
});
$(document).on("click", ".quick-view-prev",
function(c) {
    c.preventDefault();
    c.stopPropagation();
    var b = this.href;
    var d = $(this).attr("href");
    noajaxloader = true;
    productadding = true;
    $.ajax({
        url: b,
        type: "POST",
        dataType: "html",
        success: function(e) {
            noajaxloader = false;
            setTimeout(function() {
                $("#productQuickviewModal").html(e);
                $(".productQuickviewTabs").tabs();
                $("select").selectbox();
                setTimeout(function() {
                    $("#quickViewDesc").jScrollPane();
                    $("#quickViewDetails").jScrollPane();
                    $("#quickViewSize").jScrollPane();
                    $(".jspContainer").width("415");
                },
                100);
                $(".tooltip").tooltipster({
                    theme: ".my-custom-theme"
                });
                toolTip(".unfavorite-heart", "right-15 top-15", "center", "light-arrow-right");
                $("div#quickViewOtherOptions .product-quickview-share .quickview-share").mouseover(function() {
                    var f = $(this).parent().find(".socialShareDetails");
                    shareProductDetails(f);
                    $(".product-quickview-share .hero-tooltip-content1").css("display", "block");
                });
            },
            200);
        },
        error: function(g, e, f) {
            if (g.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
    $(productQuickviewModal).load(d, productQuickviewTabs);
    $(productQuickviewModal).dialog("open");
    $(".scroll-pane").jScrollPane();
});
$(document).on("click", ".quick-view-next",
function(c) {
    c.preventDefault();
    c.stopPropagation();
    var b = this.href;
    noajaxloader = true;
    productadding = true;
    $.ajax({
        url: b,
        type: "POST",
        dataType: "html",
        success: function(e) {
            noajaxloader = false;
            setTimeout(function() {
                $("#productQuickviewModal").html(e);
                InitSelect();
                $(".productQuickviewTabs").tabs();
                $(".tooltip").tooltipster({
                    theme: ".my-custom-theme"
                });
                toolTip(".unfavorite-heart", "right-15 top-15", "center", "light-arrow-right");
                setTimeout(function() {
                    $("#quickViewDesc").jScrollPane();
                    $("#quickViewDetails").jScrollPane();
                    $("#quickViewSize").jScrollPane();
                    $(".jspContainer").width("415");
                },
                100);
                $("div#quickViewOtherOptions .product-quickview-share .quickview-share").mouseover(function() {
                    var f = $(this).parent().find(".socialShareDetails");
                    shareProductDetails(f);
                    $(".product-quickview-share .hero-tooltip-content1").css("display", "block");
                });
            },
            100);
            $("div#quickViewOtherOptions .product-quickview-share").mouseover(function() {
                $(".product-quickview-share .share-links").css("display", "block");
            });
            $("div#quickViewOtherOptions .product-quickview-share").mouseleave(function() {
                setTimeout(function() {
                    if (!$(".share-links").hasClass("overActive")) {
                        $(".share-links").hide("fade", 500);
                    }
                },
                500);
            });
            $(".share-links").mouseover(function() {
                $(".share-links").addClass("overActive");
            });
            $(".share-links").mouseleave(function() {
                $(".share-links").hide("fade", 500);
                $(".share-links").removeClass("overActive");
            });
            $(document).on("click", ".share-links .share-email", sharePopup);
            $(document).on("click", "#find-store-inquickview", findStorePop);
        },
        error: function(g, e, f) {
            if (g.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
    var d = $(this).attr("href");
    $(this).dialog({
        modal: true,
        autoOpen: false,
        closeOnEscape: true,
        closeText: "Close Window",
        dialogClass: "no-close",
        draggable: false,
        resizable: false,
        position: ["center", 50],
        width: 905,
        height: "auto",
        show: {
            effect: "fade",
            duration: 300
        },
        hide: {
            effect: "fade",
            duration: 300
        }
    });
    $(productQuickviewModal).load(d, productQuickviewTabs, InitSelect);
    $(productQuickviewModal).dialog("open");
    $("select").selectbox();
    $(".scroll-pane").jScrollPane();
});
$(document).on("click", "#productQuickviewSwatchBox a",
function(b) {
    b.preventDefault();
    var c = $(this).attr("href");
    $(this).dialog({
        modal: true,
        autoOpen: false,
        closeOnEscape: true,
        closeText: "Close Window",
        dialogClass: "no-close",
        draggable: false,
        resizable: false,
        position: ["center", 100],
        width: 905,
        height: "auto",
        show: {
            effect: "fade",
            duration: 300
        },
        hide: {
            effect: "fade",
            duration: 300
        }
    });
    $(productQuickviewModal).load(c, productQuickviewTabs);
    $(productQuickviewModal).dialog("open");
});
var colorTarget = $(".product-quickview-swatch-color");
var availableInTag = "available in: ";
$(colorTarget).click(function() {
    $(".swatch-color-name").html(availableInTag + $(this).attr("data-color-name"));
    $(colorTarget).each(function() {
        $(colorTarget).parent().removeClass("active-swatch");
    });
    $(this).parent().addClass("active-swatch");
});
var productImageThumb = $("div.product-thumb img");
$(productImageThumb).click(function() {
    $(".product-quickview-main-image").attr("src", $(this).attr("data-large-img-src"));
    $(productImageThumb).parent().removeClass("active-thumb");
    $(this).parent().addClass("active-thumb");
});
function InitSelect() {
    $("select").selectbox("detach");
    $("select").selectbox();
}
function quickViewScene7(n, c, j) {
    s7sdk.Util.lib.include("s7sdk.image.ZoomView");
    s7sdk.Util.lib.include("s7sdk.event.Event");
    s7sdk.Util.lib.include("s7sdk.common.Button");
    s7sdk.Util.lib.include("s7sdk.common.Container");
    s7sdk.Util.lib.include("s7sdk.set.MediaSet");
    s7sdk.Util.lib.include("s7sdk.set.Swatches");
    var g, f, e, o, k, b;
    s7sdk.Util.init();
    g = new s7sdk.ParameterManager();
    function l() {
        g.push("serverurl", "http://s7d1.scene7.com/is/image");
        g.push("asset", n);
        g.push("cellspacing", "0, 0");
        g.push("zoomstep", "0,1");
        g.push("singleclick", "none");
        g.push("doubleclick", "none");
        g.push("iconeffect", "0,1,0.3,3");
        g.push("stagesize", "400,400");
        f = new s7sdk.Container("imagesBox", g, "s7container");
        o = new s7sdk.ZoomView("s7container", g, "pdpZoomView");
        o.addEventListener(s7sdk.AssetEvent.ASSET_CHANGED, h, false);
        b = new s7sdk.MediaSet(null, g, null);
        b.addEventListener(s7sdk.AssetEvent.NOTF_SET_PARSED, m, false);
        k = $(".swatch-container a");
        $(k).click(function(p) {
            p.preventDefault();
            n = $(this).attr("href");
            o.setAsset(n);
            e.setAsset(n);
        });
    }
    function d(q) {
        var p = q.s7event.asset;
        if ((o) && (o.item != null) && (o.item.name != p.name)) {
            console.log("thumbSelected:" + o.item.name + "-" + p.name);
            o.setItem(p);
        }
    }
    function h(p) {
        if ((e) && (e.frame != p.s7event.frame)) {
            e.selectSwatch(p.s7event.frame, true);
        }
    }
    function m(p) {
        b = p.s7event.asset;
        if (b.items.length > 1) {
            e = new s7sdk.Swatches("imagesBox", g, "quickViewSwatches");
            e.addEventListener(s7sdk.AssetEvent.SWATCH_SELECTED_EVENT, d, false);
            e.setMediaSet(b);
            e.selectSwatch(0, true);
            e.resize(400, 150);
        } else {
            if (b.items.length == 1) {
                o.setItem(b.items[0]);
            }
        }
    }
    g.addEventListener(s7sdk.Event.SDK_READY, l, false);
    g.init();
}
$(window).on("scroll",
function() {
    if ($("body").scrollTop() >= 160) {
        $("#productFilterBar").appendTo($("#miniNavHeaderContainer"));
        $("#productFilterBar").addClass("filter-bar-sticky");
        $("#headerBreadcrumb").html("<span>WOMEN</span>");
        $("div.selected-filters-list,#headerBreadcrumb").css("display", "inline-block");
        $("#imageSizeIcons").css("display", "none");
    } else {
        $("#selectedFilters").css("display", "block");
        $("#productFilterBar").insertBefore($("#productGrids"));
        $("#productFilterBar").removeClass("filter-bar-sticky");
        $("div.selected-filters-list,#headerBreadcrumb").css("display", "none");
        $("#imageSizeIcons").css("display", "inline-block");
    }
});
$(window).on("click",
function(b) {
    if (!$(b.target).is(".locate_in_store")) {
        if ($(".tooltip-store").tooltipster("show")) {
            $(".tooltip-store").tooltipster("hide");
        }
    }
});
if (($("input#skuId").val() == "") || ($("input#skuId").val() == undefined)) {
    $(".tooltip-store").tooltipster({
        trigger: "click",
        theme: ".find-in-store-tooltip"
    });
} else {
    $(".locate_in_store").tooltipster("destroy");
    $(document).on("click", ".locate_in_store", findStorePop_pdpPage);
}
function findStorePop_pdpPage(c) {
    c.preventDefault();
    $(this).addClass("active-store");
    $("#storeInput").val("");
    $("div.field-missing-text").hide();
    var b = $(this);
    $("#locateInStore_pdp").dialog({
        modal: true,
        autoOpen: true,
        closeOnEscape: true,
        closeText: "Close Window",
        dialogClass: "no-close arrow_box",
        draggable: false,
        resizable: false,
        position: {
            my: "left-148px bottom-16px",
            at: "left top",
            of: b,
            collision: "fit"
        },
        width: 270,
        height: "auto",
        show: {
            effect: "fade",
            duration: 300
        },
        hide: {
            effect: "fade",
            duration: 300
        },
        open: function(d, e) {
            $(".ui-widget-overlay").addClass("No-Overlay-findstore");
        },
        close: function(d, e) {
            $(".product-findstore").data("click-count", 0);
            $(".locate_in_store").removeClass("active-store");
        }
    });
    $("#locateInStore_pdp").dialog("open");
}
$(document).keypress(function(b) {
    if (b.which == 13) {
        b.preventDefault();
        if ($(".store-specific").is(":visible")) {
            findStores();
        } else {
            if ($("input#storeInput").val() == "") {
                CheckStoreValidation($(this));
            } else {
                if (/^[a-zA-Z0-9-/, ] * $ / .test($("input#storeInput").val()) == false) {
                    CheckStoreValidation($(this));
                } else {
                    $(".product-findstore").data("click-count", 0);
                    $(".product-findstore").click();
                }
            }
        }
    }
});
var count = "0";
$(document).on("click", ".product-findstore",
function() {
    var e = new google.maps.Geocoder();
    storeType = "";
    var b = 25;
    var c = true;
    var d = $("input#storeInput").val();
    var j = $(this);
    if ($("input#storeInput").val() == "" || $("input#storeInput").val() == "Enter a City, State or Zip Code") {
        CheckStoreValidation($(this));
    } else {
        if (/^[a-zA-Z0-9-/, ] * $ / .test(d) == false) {
            CheckStoreValidation($(this));
        } else {
            $(".product-findstore").data("click-count", 0);
            $("div.field-missing-text").hide();
            $("div#zipcodeError").hide();
            findInStoreOmniture();
            var g = $("#color-content .locate_in_store").data("CurrentValue") + "px";
            $(".arrow_box").css("top", g);
            address = $("input#storeInput").val();
            var l = $("input#skuId").val();
            var h = $("input#productId").val();
            var k = $("input#productPriceNew").val();
            var f = "?skuId=" + l + "&lookForNextAvailStore=" + c + "&productId=" + h;
            var m;
            e.geocode({
                address: address
            },
            function(o, n) {
                if (n == google.maps.GeocoderStatus.OK) {
                    address = o[0].geometry.location;
                    m = "?storetype=" + storeType + "&lat=" + o[0].geometry.location.lat() + "&lng=" + o[0].geometry.location.lng() + "&rad=" + b + "&addressField=" + d + "&skuId=" + l + "&lookForNextAvailStore=" + c + "&productId=" + h;
                    $.ajax({
                        url: "/browse/pdp/includes/pdp_locate_in_store_include.jsp" + m,
                        type: "POST",
                        dataType: "html",
                        success: function(p) {
                            loadFacebookPixel("findInStore");
                            $("#locateInStoreResults-popup").html(p);
                            $("#locateInStoreResults-popup").dialog({
                                autoOpen: false,
                                resizable: false,
                                height: "auto",
                                dialogClass: "store-specific",
                                width: 580,
                                modal: true
                            });
                            $("#locateInStoreResults-popup").dialog("open");
                            $(".popUpStoreResults").jScrollPane();
                        },
                        error: function(r, p, q) {
                            if (r.status == "409") {
                                location.href = "/account/create_account.jsp?error=409";
                            } else {
                                location.href = "/common/serverError.jsp";
                            }
                        }
                    });
                } else {
                    $.ajax({
                        url: "/browse/pdp/includes/pdp_locate_in_store_include.jsp" + f,
                        type: "POST",
                        dataType: "html",
                        success: function(p) {
                            loadFacebookPixel("findInStore");
                            $("#locateInStoreResults-popup").html(p);
                            $("#locateInStoreResults-popup").dialog({
                                autoOpen: false,
                                resizable: false,
                                height: "auto",
                                dialogClass: "store-specific",
                                width: 580,
                                modal: true
                            });
                            $("#locateInStoreResults-popup").dialog("open");
                            $(".popUpStoreResults").jScrollPane();
                        },
                        error: function(r, p, q) {
                            if (r.status == "409") {
                                location.href = "/account/create_account.jsp?error=409";
                            } else {
                                location.href = "/common/serverError.jsp";
                            }
                        }
                    });
                    console.log("Geocode was not successful for the following reason: " + n);
                }
            });
        }
    }
});
function CheckStoreValidation(f) {
    var e = f;
    var d = $("input#storeInput").val();
    var c = parseInt($(".arrow_box").css("top"));
    var b = ($(".product-findstore").data("click-count") || 0) + 1;
    $(".product-findstore").data("click-count", b);
    if (d == "" || d == "Enter a City, State or Zip Code") {
        $("div.field-missing-text").show();
        $("div#zipcodeError").hide();
        CTopFinal = c - "16px";
        if (b == 1) {
            $(".arrow_box").css("top", CTopFinal);
            $("#color-content .locate_in_store").data("CurrentValue", c);
        }
    } else {
        if (/^[a-zA-Z0-9-/, ] * $ / .test(d) == false) {
            $("div.field-missing-text").hide();
            $("div#zipcodeError").show();
        }
    }
}
$("#productDetailsAlsoLike h5#YouMightToggle").click(function() {
    var d = $(this);
    var b = d.find("div.chevron img").attr("src");
    var e = "";
    $("#productDetailsAlsoLike ul.group").slideToggle("slow",
    function() {});
    if (b == "<?PHP echo DIR_WS_TEMPLATE_IMAGES?>icon-chevron-down.png") {
        e = "<?PHP echo DIR_WS_TEMPLATE_IMAGES?>icon-chevron-up.png";
    }
    if (b == "<?PHP echo DIR_WS_TEMPLATE_IMAGES?>icon-chevron-up.png") {
        e = "<?PHP echo DIR_WS_TEMPLATE_IMAGES?>icon-chevron-down.png";
    }
    var c = d.find("div.chevron img");
    c.fadeOut("slow",
    function() {
        c.attr("src", e);
        c.fadeIn("slow");
    });
});$("#productDetailsRightSidebar #productSize").change(function() {
    if ($(this).val() == "0") {
        $(".mk_size_guide").hide();
    } else {
        $(".mk_size_guide").show();
    }
});$(document).on("click", "a.mk_size_guide",
function(d) {
    d.preventDefault();
    productadding = true;
    var c = $(this);
    var b = $("<div id='uimodal-output'></div>");
    $("body").append(b);
    b.load(c.attr("href"), InitSCrollpane(500),
    function() {
        b.dialog({
            modal: true,
            autoOpen: true,
            closeOnEscape: true,
            closeText: "Close Window",
            dialogClass: "no-close",
            draggable: false,
            resizable: false,
            position: ["center", 100],
            width: 680,
            height: 500,
            show: {
                effect: "fade",
                duration: 300
            },
            hide: {
                effect: "fade",
                duration: 300
            },
            close: function(e, f) {
                $(this).dialog("destroy").remove();
            }
        });
    });
    return false;
});$(document).on("click", ".share",
function(c) {
    c.preventDefault();
    c.stopPropagation();
    productadding = true;
    var b = this.href;
    noajaxloader = true;
    $.ajax({
        url: b,
        type: "POST",
        dataType: "html",
        success: function(d) {
            noajaxloader = false;
            console.log(d);
            $(".shareActive").html(d);
            $(".shareActive").dialog({
                autoOpen: false,
                closeOnEscape: true,
                dialogClass: "no-close",
                draggable: false,
                resizable: false,
                height: "auto",
                width: "auto",
                modal: true
            });
            $(".shareActive").dialog("open");
            $("input.css-checkbox").customInput();
        }
    });
});$(document).on("click", ".share_email",
function(c) {
    c.preventDefault();
    c.stopPropagation();
    var b = this.href;
    productadding = true;
    noajaxloader = true;
    $.ajax({
        url: b,
        type: "POST",
        dataType: "html",
        success: function(d) {
            noajaxloader = false;
            $(".shareActive").html(d);
            $(".shareActive").dialog({
                autoOpen: false,
                closeOnEscape: true,
                dialogClass: "no-close",
                draggable: false,
                resizable: false,
                height: "auto",
                width: "auto",
                modal: true
            });
            $(".shareActive").dialog("open");
            $("input.css-checkbox").customInput();
        },
        error: function(f, d, e) {
            if (f.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
});$("li.featuredProducts .favorite-actions .share-links .share-email").on("click", sharePopup);$("#categoryList .favorite-actions .share-links .share-email").on("click", sharePopup);$(".product-panel-small .product-panel-active .action-icons .share-links .share-email").on("click", sharePopup);$(document).on("click", ".category-large-container .action-icons .share-links .share-email", sharePopup);$("#favoritedItemsContainer .favorite-actions .share-links .share-email").on("click", sharePopup);$("#send_by_dropdown_detail").change(function() {
    if ($("#send_by_dropdown_detail").val() == "true") {
        noajaxloader = true;
        productadding = true;
        $.ajax({
            url: "/browse/giftcard/includes/share_wish_list_popup.jsp",
            type: "POST",
            dataType: "html",
            success: function(b) {
                noajaxloader = false;
                productadding = false;
                $(".shareActive").html(b);
                $(".shareActive").dialog({
                    height: 420,
                    resizable: false,
                    width: 584,
                    modal: true,
                    open: function() {}
                });
                $(".shareActive").dialog("open");
            },
            error: function(d, b, c) {
                if (d.status == "409") {
                    location.href = "/account/create_account.jsp?error=409";
                } else {
                    location.href = "/common/serverError.jsp";
                }
            }
        });
    }
});$(document).ready(function() {
    $(".share-dialog-close-button").on("click",
    function() {
        $(".shareActive").dialog("close");
    });
});$("#gift_amount").change(function() {
    if ($("#gift_amount").val() == "other") {
        $(".ur_amount").css("display", "block");
    } else {
        $(".ur_amount").css("display", "none");
    }
});$(window).scroll(function() {
    if ($(this).scrollTop() > 200) {
        $(".top-navigation").fadeIn();
    } else {
        $(".top-navigation").fadeOut();
    }
    var c = $("#footer").height() + 10;
    var b = $("#footer").parent().find(".group").height();
    var d = c + b + "px";
    if ($(window).scrollTop() + $(window).height() >= $(document).height() - c) {
        $(".top-navigation").css("bottom", d);
    } else {
        $(".top-navigation").css("bottom", "70px");
    }
});$(document).ready(function() {
    $(document).on("click", ".top-navigation",
    function(b) {
        b.preventDefault();
        $("html, body").animate({
            scrollTop: "0px"
        },
        800);
    });
    $(".youmight").bind("touchstart",
    function() {
        if ($(this).attr("href") != "#") {
            location.href = $(this).attr("href");
        }
    });
    $(".share-email").bind("touchstart", sharePopup);
});
function sharePopup(c) {
    c.stopPropagation();
    c.preventDefault();
    var b = this.href;
    noajaxloader = true;
    productadding = true;
    $.ajax({
        url: b,
        type: "POST",
        dataType: "html",
        success: function(d) {
            $(".shareActive").html(d);
            $("input.css-checkbox").customInput();
            noajaxloader = false;
            $(".shareActive").dialog({
                autoOpen: false,
                closeOnEscape: true,
                dialogClass: "no-close",
                draggable: false,
                resizable: false,
                height: "auto",
                width: "auto",
                modal: true
            });
            $(".shareActive").dialog("open");
            $(".share-dialog-close-button").on("click",
            function() {
                $(".shareActive").dialog("close");
            });
        },
        error: function(f, d, e) {
            if (f.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
}
function changeOutfitQuickViewProductColor(c, b) {
    noajaxloader = true;
    $.ajax({
        url: "/browse/outfit/includes/ajax_outfit_quickview_item.jsp?productId=" + c + "&color=" + b,
        success: function(e) {
            var d = "outfitQuick_" + c;
            $("#" + d).replaceWith(e);
            InitSelect();
            $(".tooltip").tooltipster({
                theme: ".my-custom-theme"
            });
            outfitQuickViewCheckInventory();
            noajaxloader = false;
            outfitqvTabindex();
            $("#" + d).find("#productColors li a img").trigger("focus");
        },
        error: function(f, d, e) {
            if (f.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
}
function changeOutfitQuickViewProductSize(d, c, b) {
    noajaxloader = true;
    $.ajax({
        url: "/browse/outfit/includes/ajax_outfit_quickview_item.jsp?productId=" + d + "&color=" + c + "&skuId=" + b,
        success: function(f) {
            var e = "outfitQuick_" + d;
            $("#" + e).replaceWith(f);
            InitSelect();
            $(".tooltip").tooltipster({
                theme: ".my-custom-theme"
            });
            outfitQuickViewCheckInventory();
            noajaxloader = false;
            outfitqvTabindex();
            $("#" + e).find(".sizes-qnty").find(".sbHolder").trigger("focus");
        },
        error: function(g, e, f) {
            if (g.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
}
function changeOutfitQuickViewLargeProductColor(c, b) {
    noajaxloader = true;
    $.ajax({
        url: "/browse/outfit/includes/ajax_outfit_large_quickview_item.jsp?productId=" + c + "&color=" + b,
        success: function(e) {
            var d = "outfitItem_" + c;
            $("#" + d).replaceWith(e);
            InitSelect();
            outfitLargeQuickViewCheckInventory();
            noajaxloader = false;
            outfitpdpTabindex();
            $("#" + d).find("#productColors li a img").trigger("focus");
        },
        error: function(f, d, e) {
            if (f.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
}
function changeOutfitLargeQuickViewProductSize(d, c, b) {
    noajaxloader = true;
    $.ajax({
        url: "/browse/outfit/includes/ajax_outfit_large_quickview_item.jsp?productId=" + d + "&color=" + c + "&skuId=" + b,
        success: function(f) {
            var e = "outfitItem_" + d;
            $("#" + e).replaceWith(f);
            InitSelect();
            outfitLargeQuickViewCheckInventory();
            noajaxloader = false;
            trendspdpTabindex();
            toolTip(".share", "right-15 center", "right-15 center", "light-arrow-right");
            toolTip(".unfavorite-heart", "right-15 top-15", "center", "light-arrow-right");
            toolTip(".favorite-heart", "right-15 top-15", "center", "light-arrow-right");
            var g = $(".outfit-item-select-size").attr("sb");
            $("#sbHolder_" + g + " .sbFocus").parent().addClass("selected");
            $("#" + e).find(".size-container").find(".sbHolder").trigger("focus");
        },
        error: function(g, e, f) {
            if (g.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
}
function trendspdpTabindex() {
    $("div.outfit-item").each(function(b) {
        $(this).attr("tabindex", "32");
        $(this).find(".outfit-item-info").find("img.outfit-item-tn").attr("tabindex", "32");
        $(this).find(".outfit-item-info").find("img.outfit-item-tn").on("keydown",
        function() {
            if (event.keyCode == 13) {
                $(this).trigger("click");
            }
        });
        $(this).find("#productColors li a img").attr("tabindex", "32");
        $(this).find("#productColors li a img").on("keydown",
        function() {
            if (event.keyCode == 13) {
                $(this).trigger("click");
            }
        });
        $(this).find(".size-container .mk_size_guide").attr("tabindex", "32");
        $(this).find(".size-container .mk_size_guide").on("focus",
        function() {
            $(this).css("border", "1px solid #AB9259");
        }).on("focusout",
        function() {
            $(this).css("border", "none");
        }).bind("keydown",
        function() {
            if (event.keyCode == 13) {
                $(this).trigger("click");
                $(this).trigger("focus");
            }
        });
        $(this).find(".size-container").find(".sbHolder").removeAttr("tab-index").attr("tabindex", "32");
        $(this).find(".size-container").find(".sbToggle,.sbSelector").removeAttr("tab-index").removeAttr("tabindex");
        $(this).find(".size-container").find(".sbHolder").on("keydown",
        function() {
            if (event.keyCode == 13) {
                $(this).children(".sbSelector").trigger("click");
                $(this).focus();
            }
            if (event.keyCode == 9) {
                $(this).parent(".size-container").siblings(".qty-container").find(".sbHolder").focus();
            }
        });
        $(this).find(".qty-container").find(".sbHolder").removeAttr("tab-index").attr("tabindex", "32");
        $(this).find(".qty-container").find(".sbToggle,.sbSelector").removeAttr("tab-index").removeAttr("tabindex");
        $(this).find(".qty-container").find(".sbHolder").on("keydown",
        function() {
            if (event.keyCode == 13) {
                $(this).children(".sbSelector").trigger("click");
                $(this).focus();
            }
            if (event.keyCode == 9) {
                $(this).parent(".qty-container").parent(".outfit_space_top").find(".add-to-bag-shine").find("#addToBag").focus();
            }
        });
        $(this).find(".add-to-bag-shine #addToBag").removeAttr("tabindex").attr("tabindex", "32");
        $(this).find(".add-to-bag-shine #addToBag").on("focus",
        function() {
            $(this).css("border", "5px solid #AB9259");
        }).on("focusout",
        function() {
            $(this).css("border", "none");
        });
        $(this).find(".add-to-fave a").removeAttr("tabindex").attr("tabindex", "32");
        $(this).find(".add-to-fave a").on("keydown",
        function() {
            if (event.keyCode == 13) {
                $(this).trigger("click");
            }
        });
    });
    $("div.outfit-item").on("focus",
    function() {
        $(this).find(".outfit-item-info").find("img.outfit-item-tn").trigger("focus");
    });
    $(".share_btn input").removeAttr("tabindex").attr("tabindex", "32");
    $(".share_btn input").on("keydown",
    function() {
        if (event.keyCode == 13) {
            $(this).trigger("click");
        }
    }).on("focus",
    function() {
        $(this).css("border", "5px solid #AB9259");
    }).on("focusout",
    function() {
        $(this).css("border", "none");
    });
}
function changeOutfitProductColor(c, b) {
    noajaxloader = true;
    productadding = true;
    $.ajax({
        url: "/browse/outfit/includes/ajax_outfit_item.jsp?productId=" + c + "&color=" + b,
        success: function(e) {
            var d = "outfitItem_" + c;
            $("#" + d).replaceWith(e);
            $("#productDescriptionTab").tabs().show().find("li").removeAttr("tabindex").attr("tabindex", "32");
            $("#productDescription").jScrollPane();
            $("#productDescription").removeAttr("tabindex");
            scene7($("#imageSetPath").text());
            InitSelect();
            outfitCheckInventory();
            noajaxloader = false;
            productadding = false;
            outfitpdpTabindex();
            $("#" + d).find("#productColors li a img").trigger("focus");
        },
        error: function(f, d, e) {
            if (f.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
}
function changeOutfitProductSize(d, c, b) {
    noajaxloader = true;
    productadding = true;
    $.ajax({
        url: "/browse/outfit/includes/ajax_outfit_item.jsp?productId=" + d + "&color=" + c + "&skuId=" + b,
        success: function(f) {
            var e = "outfitItem_" + d;
            $("#" + e).replaceWith(f);
            $("#productDescriptionTab").tabs().show().find("li").removeAttr("tabindex").attr("tabindex", "32");
            $("#productDescription").jScrollPane();
            $("#productDescription").removeAttr("tabindex");
            InitSelect();
            outfitCheckInventory();
            noajaxloader = false;
            productadding = false;
            toolTip(".share", "right-15 center", "right-15 center", "light-arrow-right");
            toolTip(".unfavorite-heart", "right-15 top-15", "center", "light-arrow-right");
            toolTip(".favorite-heart", "right-15 top-15", "center", "light-arrow-right");
            outfitpdpTabindex();
            $("#" + e).find(".size-container").find(".sbHolder").trigger("focus");
        },
        error: function(g, e, f) {
            if (g.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
}
function changeColor(e, d, b, f) {
    productadding = true;
    if ($(document).find("#locateInStore_pdp").hasClass("ui-dialog-content")) {
        $("#locateInStore_pdp").dialog("destroy").remove();
    }
    var c = f + "?productId=" + e + "&color=" + d;
    noajaxloader = true;
    $.ajax({
        url: c,
        success: function(h) {
            $("#" + b).html(h);
            $("#productDescriptionTab").tabs().show().find("li").removeAttr("tabindex").attr("tabindex", "32");
            $("#productDescription").jScrollPane();
            $("#productDescription").removeAttr("tabindex");
            $("select").selectbox();
            $("#productDescription").jScrollPane();
            $("#productListItemDetails").jScrollPane();
            scene7($("#imageSetPath").text());
            var g = $("#scene7BaseURL").text() + $("#imageSetPath").text();
            $("#imageUrlForMetaTag").attr("content", g);
            toolTip(".share", "right-15 center", "right-15 center", "light-arrow-right");
            toolTip(".unfavorite-heart", "right-15 top-15", "center", "light-arrow-right");
            toolTip(".favorite-heart", "right-15 top-15", "center", "light-arrow-right");
            $("#closeFlyout").click(function() {
                $("#productDetailsFlyout").toggleClass("show", 200);
            });
            $(".swatch-container").find("li a.tooltip, li a img.tooltip").tooltipster({
                theme: ".my-custom-theme"
            });
            $("#closeFlyout").trigger("click");
            if (($("input#skuId").val() == "") || ($("input#skuId").val() == undefined)) {
                $(".tooltip-store").tooltipster({
                    trigger: "click",
                    theme: ".find-in-store-tooltip"
                });
            } else {
                $(".locate_in_store").tooltipster("destroy");
                $(".locate_in_store").click(findStorePop_pdpPage);
            }
            checkInventory();
            swatchColorSelected();
            noajaxloader = false;
            refreshShareSection();
            $("#color-content  #productColors li a img").trigger("focus");
        },
        error: function(j, g, h) {
            if (j.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
}
function changeSize(f, e, c, b, g) {
    if ($(document).find("#locateInStore_pdp").hasClass("ui-dialog-content")) {
        $("#locateInStore_pdp").dialog("destroy").remove();
    }
    noajaxloader = true;
    var d = g + "?productId=" + f + "&color=" + e + "&skuId=" + c;
    $.ajax({
        url: d,
        success: function(h) {
            console.log(h);
            $("#" + b).html(h);
            $("#color-content").find(".sbHolder").focus();
            $("#productDescriptionTab").tabs().show();
            $("select").selectbox();
            var j = $("select[name=selectedSize]").attr("sb");
            $("#sbHolder_" + j + " .sbFocus").parent().addClass("selected");
            scene7($("#imageSetPath").text());
            toolTip(".share", "right-15 center", "right-15 center", "light-arrow-right");
            toolTip(".unfavorite-heart", "right-15 top-15", "center", "light-arrow-right");
            toolTip(".favorite-heart", "right-15 top-15", "center", "light-arrow-right");
            $("#closeFlyout").click(function() {
                $("#productDetailsFlyout").toggleClass("show", 200);
            });
            $(".swatch-container").find("li a.tooltip, li a img.tooltip").tooltipster({
                theme: ".my-custom-theme"
            });
            $("#closeFlyout").trigger("click");
            if (($("input#skuId").val() == "") || ($("input#skuId").val() == undefined)) {
                $(".tooltip-store").tooltipster({
                    trigger: "click",
                    theme: ".find-in-store-tooltip"
                });
            } else {
                $(".locate_in_store").tooltipster("destroy");
                $(".locate_in_store").click(findStorePop_pdpPage);
            }
            checkInventory();
            swatchColorSelected();
            noajaxloader = false;
            refreshShareSection();
            $("#productDescription").jScrollPane();
            $("#color-content .productSizer .sbHolder").trigger("focus");
        },
        error: function(k, h, j) {
            if (k.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
}
function largeViewChangeColor(f, e, b, h, d) {
    var c = h + "?productId=" + f + "&color=" + e + "&colorCodeRollUp=" + d;
    var g = b + "_" + f + "_" + d;
    noajaxloader = true;
    $.ajax({
        url: c,
        success: function(j) {
            $("#" + g).html(j);
            InitSelect();
            noajaxloader = false;
        },
        error: function(l, j, k) {
            if (l.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
    largeviewTabindex();
}
function largeViewChangeSize(g, f, c, b, j, e) {
    var d = j + "?productId=" + g + "&color=" + f + "&skuId=" + c + "&colorCodeRollUp=" + e;
    var h = b + "_" + g + "_" + e;
    noajaxloader = true;
    productadding = true;
    $.ajax({
        url: d,
        success: function(k) {
            $("#" + h).html(k);
            InitSelect();
            noajaxloader = false;
            productadding = false;
            largeViewlistingindex();
            setTimeout(function() {
                var m = $("#largeViewListSize").attr("sb");
                $("#sbHolder_" + m + " .sbFocus").parent().addClass("selected");
                $("#sbHolder_" + m).focus();
            },
            3000);
        },
        error: function(m, k, l) {
            if (m.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
}
function qvChangeColor(f, c, b) {
    productadding = true;
    var e = $("#editCartcommItemId").val();
    var g = $("#editCartpage").val();
    var d = $("#addedfromyoumaylike").val();
    noajaxloader = true;
    $.ajax({
        url: "/browse/pdp/ajax/ajax_product_quick_view_include.jsp?productId=" + f + "&color=" + c + "&commItemId=" + e + "&editCart=" + g + "&addedfromyoumaylike=" + d,
        success: function(h) {
            $("#" + b).html(h);
            $(".tooltip").tooltipster({
                theme: ".my-custom-theme"
            });
            toolTip(".product-quickview-favorite a", "right-15 center", "right-15 center", "light-arrow-right");
            $("div#quickViewOtherOptions .product-quickview-share .quickview-share").mouseover(function() {
                var j = $(this).parent().find(".socialShareDetails");
                shareProductDetails(j);
                $(".product-quickview-share .hero-tooltip-content1").css("display", "block");
            });
            $("div#quickViewOtherOptions .product-quickview-share").mouseleave(function() {
                setTimeout(function() {
                    if (!$(".share-links").hasClass("overActive")) {
                        $(".share-links").hide("fade", 500);
                    }
                },
                500);
            });
            $(".share-links").mouseover(function() {
                $(".share-links").addClass("overActive");
            });
            $(".share-links").mouseleave(function() {
                $(".share-links").hide("fade", 500);
                $(".share-links").removeClass("overActive");
            });
            $(".share-links .share-email").unbind("click", sharePopup).bind("click", sharePopup);
            $("#find-store-inquickview").unbind("click", findStorePop).bind("click", findStorePop);
            $("#quickViewDesc").jScrollPane();
            $("#quickViewDetails").jScrollPane();
            $("#quickViewSize").jScrollPane();
            $("select").selectbox();
            $("#quickViewDesc").removeAttr("tabindex");
            $(".productQuickviewTabs").tabs().find("li").each(function() {
                $(this).removeAttr("tabindex").attr("tabindex", "149");
                i++;
            });
            qvTabindex();
            $("#productQuickviewSwatchBox img").trigger("focus");
            checkInventory();
            noajaxloader = false;
            if ($(".recommenedImages").length) {
                $(".quick-view-next, .quick-view-prev").hide();
            }
        },
        error: function(k, h, j) {
            if (k.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
}
function qvChangeSize(e, d, c, b) {
    $("#editProductSize").find(".sbSelector").trigger("click");
    setTimeout(function() {
        var g = $("#editCartcommItemId").val();
        var h = $("#editCartpage").val();
        var f = $("#addedfromyoumaylike").val();
        noajaxloader = true;
        productadding = true;
        $.ajax({
            url: "/browse/pdp/ajax/ajax_product_quick_view_include.jsp?productId=" + e + "&color=" + d + "&skuId=" + c + "&commItemId=" + g + "&editCart=" + h + "&addedfromyoumaylike=" + f,
            success: function(j) {
                $("#" + b).html(j);
                $(".tooltip").tooltipster({
                    theme: ".my-custom-theme"
                });
                toolTip(".product-quickview-favorite a", "right-15 center", "right-15 center", "light-arrow-right");
                $("div#quickViewOtherOptions .product-quickview-share .quickview-share").mouseover(function() {
                    var l = $(this).parent().find(".socialShareDetails");
                    shareProductDetails(l);
                    $(".product-quickview-share .hero-tooltip-content1").css("display", "block");
                });
                $("div#quickViewOtherOptions .product-quickview-share").mouseleave(function() {
                    setTimeout(function() {
                        if (!$(".share-links").hasClass("overActive")) {
                            $(".share-links").hide("fade", 500);
                        }
                    },
                    500);
                });
                $(".share-links").mouseover(function() {
                    $(".share-links").addClass("overActive");
                });
                $(".share-links").mouseleave(function() {
                    $(".share-links").hide("fade", 500);
                    $(".share-links").removeClass("overActive");
                });
                $(".share-links .share-email").unbind("click", sharePopup).bind("click", sharePopup);
                $("#find-store-inquickview").on("mouseover",
                function(l) {
                    if ($("#qvChangeSizeValue option:selected").val() == "") {} else {
                        $("#find-store-inquickview").tooltipster("destroy");
                        $("#find-store-inquickview").removeAttr("title", "Please select<br/>a Color/Size");
                        $("#find-store-inquickview").attr("title", "Find in a store");
                        $("#find-store-inquickview").removeClass("tooltip");
                        $("#find-store-inquickview").unbind("click", findStorePop).bind("click", findStorePop);
                    }
                });
                $("#quickViewDesc").jScrollPane();
                $("#quickViewDetails").jScrollPane();
                $("#quickViewSize").jScrollPane();
                $("select").selectbox();
                var k = $("#qvChangeSizeValue").attr("sb");
                $("#sbHolder_" + k + " .sbFocus").parent().addClass("selected");
                $(".productQuickviewTabs").tabs().find("li").removeAttr("tabindex").attr("tabindex", "149");
                $("#quickViewDesc").jScrollPane();
                $("#quickViewDesc").removeAttr("tabindex");
                qvTabindex();
                $("#editProductSize").find(".sbHolder").trigger("focus");
                event.stopPropagation();
                checkInventory();
                noajaxloader = false;
                productadding = false;
            },
            error: function(l, j, k) {
                if (l.status == "409") {
                    location.href = "/account/create_account.jsp?error=409";
                } else {
                    location.href = "/common/serverError.jsp";
                }
            }
        });
    },
    1000);
}
function findStorePop() {
    var g = new google.maps.Geocoder();
    var f = true;
    var h = $("input#catalogRefId").val();
    var d = $("input#productId").val();
    var c = "?skuId=" + h;
    var e = "&productId=" + d;
    var b = c + "&lookForNextAvailStore=" + f + e;
    $(".store_field").val("");
    productadding = true;
    $.ajax({
        url: "/browse/common/locate_in_store.jsp" + c + e,
        type: "POST",
        dataType: "html",
        success: function(j) {
            $("#locateInStore").html(j);
            $("#locateInStore").dialog({
                autoOpen: false,
                resizable: false,
                height: "auto",
                width: 290,
                modal: true
            });
            $("#locateInStore").dialog("open");
            $(".find-store-dialog-close-button").click(function() {
                $("#locateInStore").dialog("close");
            });
            productadding = false;
            var k = $(".ui-dialog.ui-widget.ui-widget-content").eq(1).css("z-index");
            $("#locateInStore").parents(".ui-dialog.ui-widget.ui-widget-content").css({
                "z-index": k + 1
            });
            $("#locateInStore").parents(".ui-dialog.ui-widget.ui-widget-content").prev(".ui-widget-overlay.ui-front").css({
                "z-index": k + 1
            });
            $(".store_field").keypress(function(m) {
                var l = m.which;
                if (l == 13) {
                    $(".pdp-findstore").trigger("click");
                }
            });
            $("#locateInStore").find("button.pdp-findstore").on("click",
            function() {
                productadding = true;
                var m = $("input.store_field").val();
                if (($(".store_field").val() == null) || ($(".store_field").val() == "") || ($(".store_field").val() == "Enter a City, State or Zip Code")) {
                    $("div.field-missing-text").show();
                    $("div#zipcodeError").hide();
                } else {
                    if (/^[a-zA-Z0-9-/, ] * $ / .test(m) == false) {
                        $("div.field-missing-text").hide();
                        $("div#zipcodeError").show();
                    } else {
                        $("div.field-missing-text").hide();
                        $("div#zipcodeError").hide();
                        storeType = "";
                        var l = 25;
                        address = $("input.store_field").val();
                        var n;
                        g.geocode({
                            address: address
                        },
                        function(q, o) {
                            if (o == google.maps.GeocoderStatus.OK) {
                                $("#locateInStore").dialog("close");
                                var p = $("<div></div>").addClass("ajax_overlay");
                                var r = $("<div></div>").addClass("ajax_loader");
                                $("body").append(p);
                                $("body").append(r);
                                address = q[0].geometry.location;
                                n = "?storetype=" + storeType + "&lat=" + q[0].geometry.location.lat() + "&lng=" + q[0].geometry.location.lng() + "&rad=" + l + "&addressField=" + m + "&skuId=" + h + "&lookForNextAvailStore=" + f + "&productId=" + d;
                                $.ajax({
                                    url: "/browse/pdp/includes/pdp_locate_in_store_include.jsp" + n,
                                    type: "POST",
                                    dataType: "html",
                                    success: function(t) {
                                        $("#locateInStoreResults-popup").html(t);
                                        $("#locateInStoreResults-popup").dialog({
                                            autoOpen: false,
                                            resizable: false,
                                            height: "auto",
                                            width: 580,
                                            modal: true
                                        });
                                        $("#locateInStoreResults-popup").dialog("open");
                                        $(".ajax_overlay, .ajax_loader").remove();
                                        $(".popUpStoreResults").jScrollPane();
                                        $("#locateInStoreResults-popup").parents(".ui-dialog.ui-widget.ui-widget-content").css({
                                            "z-index": k + 2
                                        });
                                        $("#locateInStoreResults-popup").parents(".ui-dialog.ui-widget.ui-widget-content").prev(".ui-widget-overlay.ui-front").css({
                                            "z-index": k + 2
                                        });
                                        productadding = false;
                                        loadFacebookPixel("findInStore");
                                    },
                                    error: function(v, t, u) {
                                        if (v.status == "409") {
                                            location.href = "/account/create_account.jsp?error=409";
                                        } else {
                                            location.href = "/common/serverError.jsp";
                                        }
                                    }
                                });
                            } else {
                                var p = $("<div></div>").addClass("ajax_overlay");
                                var r = $("<div></div>").addClass("ajax_loader");
                                $("body").append(p);
                                $("body").append(r);
                                $.ajax({
                                    url: "/browse/pdp/includes/pdp_locate_in_store_include.jsp" + b,
                                    type: "POST",
                                    dataType: "html",
                                    success: function(t) {
                                        $("#locateInStoreResults-popup").html(t);
                                        $("#locateInStoreResults-popup").dialog({
                                            autoOpen: false,
                                            resizable: false,
                                            height: "auto",
                                            width: 580,
                                            modal: true
                                        });
                                        $("#locateInStoreResults-popup").dialog("open");
                                        $(".ajax_overlay, .ajax_loader").remove();
                                        $(".popUpStoreResults").jScrollPane();
                                        $("#locateInStoreResults-popup").parents(".ui-dialog.ui-widget.ui-widget-content").css({
                                            "z-index": k + 2
                                        });
                                        $("#locateInStoreResults-popup").parents(".ui-dialog.ui-widget.ui-widget-content").prev(".ui-widget-overlay.ui-front").css({
                                            "z-index": k + 2
                                        });
                                    },
                                    error: function(v, t, u) {
                                        if (v.status == "409") {
                                            location.href = "/account/create_account.jsp?error=409";
                                        } else {
                                            location.href = "/common/serverError.jsp";
                                        }
                                    }
                                });
                                console.log("Geocode was not successful for the following reason: " + o);
                            }
                        });
                    }
                }
            });
        },
        error: function(l, j, k) {
            if (l.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
}
function findStores() {
    $(".store_field").val("");
    var j = new google.maps.Geocoder();
    storeType = "";
    var c = 25;
    var g = true;
    var d = $("div#locateInStoreResults-popup input#popResultInputVal").val();
    address = $("div#locateInStoreResults-popup input#popResultInputVal").val();
    if (d == "" || d == "Enter a City, State or Zip Code") {
        $("div.field-missing-text-results").show();
        $("div#zipcodeError").hide();
    } else {
        if (/^[a-zA-Z0-9-/, ] * $ / .test(d) == false) {
            $("div.field-missing-text-results").hide();
            $("div#zipcodeError").show();
        } else {
            $("div.field-missing-text-results").hide();
            $("div#zipcodeError").hide();
            findInStoreOmniture();
            var h = $("input#skuId").val();
            var f = $("input#productId").val();
            var b = "?skuId=" + h + "&lookForNextAvailStore=" + g + "&productId=" + f;
            var e;
            j.geocode({
                address: address
            },
            function(l, k) {
                if (k == google.maps.GeocoderStatus.OK) {
                    address = l[0].geometry.location;
                    e = "?storetype=" + storeType + "&lat=" + l[0].geometry.location.lat() + "&lng=" + l[0].geometry.location.lng() + "&rad=" + c + "&addressField=" + d + "&skuId=" + h + "&lookForNextAvailStore=" + g + "&productId=" + f;
                    $.ajax({
                        url: "/browse/pdp/includes/pdp_locate_in_store_include.jsp" + e,
                        type: "POST",
                        dataType: "html",
                        success: function(m) {
                            $("#locateInStoreResults-popup").html(m);
                            $("#locateInStoreResults-popup").dialog({
                                autoOpen: false,
                                resizable: false,
                                height: "auto",
                                width: 580,
                                modal: true
                            });
                            $("#locateInStoreResults-popup").dialog("open");
                            setTimeout(function() {
                                $(".popUpStoreResults").jScrollPane();
                            },
                            200);
                        },
                        error: function(o, m, n) {
                            if (o.status == "409") {
                                location.href = "/account/create_account.jsp?error=409";
                            } else {
                                location.href = "/common/serverError.jsp";
                            }
                        }
                    });
                } else {
                    $.ajax({
                        url: "/browse/pdp/includes/pdp_locate_in_store_include.jsp" + b,
                        type: "POST",
                        dataType: "html",
                        success: function(m) {
                            $("#locateInStoreResults-popup").html(m);
                            $("#locateInStoreResults-popup").dialog({
                                autoOpen: false,
                                resizable: false,
                                height: "auto",
                                width: 580,
                                modal: true
                            });
                            $("#locateInStoreResults-popup").dialog("open");
                            setTimeout(function() {
                                $(".popUpStoreResults").jScrollPane();
                            },
                            200);
                        },
                        error: function(o, m, n) {
                            if (o.status == "409") {
                                location.href = "/account/create_account.jsp?error=409";
                            } else {
                                location.href = "/common/serverError.jsp";
                            }
                        }
                    });
                    console.log("Geocode was not successful for the following reason: " + k);
                }
            });
        }
    }
}
$("body").on("click", "#checkGiftCardBalaceLink",
function(c) {
    var b = this.href;
    c.preventDefault();
    c.stopPropagation();
    $.ajax({
        url: b,
        type: "POST",
        dataType: "html",
        success: function(d) {
            $("#checkGiftCardBalncepop").html(d);
            $("#checkGiftCardBalncepop").dialog({
                autoOpen: false,
                resizable: false,
                height: "auto",
                width: "auto",
                modal: true,
                open: function() {
                    $("#checkGiftCardBalncepop").attr("tabindex", "105");
                    $("#giftCardNumber,#pin").attr("tabindex", "106");
                    $("#giftCardBalance").attr("tabindex", "107");
                    $(".dialog-close-button").attr("tabindex", "108");
                    $("#giftCardBalance,.dialog-close-button").keypress(function(f) {
                        if (f.keyCode == 13) {
                            $(this).trigger("click");
                        }
                    });
                }
            });
            $("#checkGiftCardBalncepop").dialog("open");
            $(".find-store-dialog-close-button").click(function() {
                $("#checkGiftCardBalncepop").dialog("close");
            });
        },
        error: function(f, d, e) {
            if (f.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
});$(".have_card").on("click",
function() {
    $.ajax({
        url: "/checkout/includes/check_gift_card_balance.jsp",
        type: "POST",
        dataType: "html",
        success: function(b) {
            $(".check_balance_container").html(b);
            $(".check_balance_container").dialog({
                autoOpen: false,
                modal: true,
                dialogClass: "no-close",
                closeText: "Close Window",
                draggable: false,
                resizable: false,
                width: 500,
                height: "auto",
                show: {
                    effect: "fade",
                    duration: 300
                },
                hide: {
                    effect: "fade",
                    duration: 300
                },
                open: function() {
                    setTimeout(function() {
                        $("#giftcardbalanceForm #giftCardNumber").focus();
                        $("#giftcardbalanceForm #giftCardBalance").off("keydown").on("keydown",
                        function(c) {
                            if (c.keyCode === 13 || c.keyCode === 32) {
                                $("#giftcardbalanceForm").submit();
                            }
                        });
                    },
                    1000);
                }
            });
            $(".check_balance_container").dialog("open");
            setTimeout(function() {},
            300);
        },
        error: function(d, b, c) {
            if (d.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
});$(".dialog-close-button-check").click(function() {
    $(".check_balance_container").dialog("close");
});$(document).on("click", ".dialog-close-button-sizeguide",
function(b) {
    $("#uimodal-output").dialog("close");
});$(".deleteFavourites").click(function(c) {
    c.preventDefault();
    var b = $(this).attr("rel");
    var d = $(this).attr("href");
    $("#dialog-confirm-delete").css("display", "block");
    $("#dialog-confirm-delete").dialog({
        resizable: false,
        height: "auto",
        width: "auto",
        modal: true,
        buttons: {
            ok: function() {
                $(this).dialog("close");
                $.ajax({
                    type: "GET",
                    url: d,
                    dataType: "html",
                    success: function(e) {
                        location.reload();
                    }
                });
            },
            Cancel: function() {
                $(this).dialog("close");
                return false;
            }
        }
    });
});$(document).on("click", ".removeFromCoupons",
function(b) {
    b.preventDefault();
    $.ajax({
        url: $(this).attr("href"),
        type: "post",
        dataType: "json",
        success: function(c) {
            if ("failure" == c.result) {
                location.href = shoppingBagLink + "?status=removefailure";
            } else {
                $.ajax({
                    url: "/includes/miniBagDetail.jsp",
                    type: "POST",
                    dataType: "html",
                    success: function(d) {
                        $("#miniCartContiainer").html(d);
                    }
                });
                jQuery.ajax({
                    url: "/checkout/includes/shop_cart_include.jsp",
                    type: "POST",
                    dataType: "html",
                    success: function(d) {
                        $("#cartContainer").replaceWith(d);
                        $("select").selectbox();
                        $("#promocoderemoved").show();
                        SetTabIndexForcheckOut();
                        setTimeout(function() {
                            $("input.css-checkbox").customInput();
                        },
                        1000);
                    }
                });
            }
        },
        error: function(e, c, d) {
            if (e.status == "409") {
                location.href = "/account/create_account.jsp?error=409";
            } else {
                location.href = "/common/serverError.jsp";
            }
        }
    });
});$(document).on("click", "#addCoupon",
function(b) {
    b.preventDefault();
    $(".addCouponConatiner").hide();
    $("#istcouponCodeLine").show();
    $("#globalError").focus();
});$(document).on("click", ".expressCheckout",
function(b) {
    b.preventDefault();
    $("#expressCheckoutButton").click();
});
function searchEvent(c, b, e) {
    var d = $("#searchText").val();
    _gaq.push([c, b, e, d]);
}
$(document).on("change", "#giftCardAmountdetail",
function(b) {
    b.preventDefault();
    var c = $("#giftCardAmountdetail :selected").val();
    if (c == "other") {
        $("#SelectInputdetail").show();
        $("#SelectInputdetail").attr("tabindex", "35");
        $("#addGiftItemToBag").attr("tabindex", "36");
        $("#SelectInputdetail").focus();
    } else {
        $("#SelectInputdetail").hide();
        $("#SelectInputdetail").attr("tabindex", "35");
        $("#addGiftItemToBag").attr("tabindex", "35");
    }
});
function fnAddGiftItemToBag() {
    var errMsg = null;
    $(".missingFields").empty();
    var dropdownval = $("#send_by_dropdown_detail :selected").val();
    var dropDownAmount = $("#giftCardAmountdetail :selected").val();
    if (dropdownval == "pleaseSelect") {
        errMsg = $("#missingSelect").val();
        $("#missingFields").html(errMsg).show();
        return false;
    } else {
        if (dropDownAmount == 0) {
            errMsg = $("#missingAmount").val();
            $("#missingFields").html(errMsg).show();
            return false;
        } else {
            if (dropDownAmount == "other") {
                var maxVal = parseInt($("#giftCardMaxVal").val());
                var minVal = parseInt($("#giftCardMinVal").val());
                var dropDownAmount = $("#SelectInputdetail").val();
                if (dropDownAmount == "") {
                    var eval = $("#emptyInputAmt").val();
                    $("#giftCardAmtErr").html(eval).show();
                    errMsg = $("#missingtextAmount").val();
                    $("#missingFields").html(errMsg).show();
                    return false;
                } else {
                    dropDownAmount = parseInt(dropDownAmount);
                    if (dropDownAmount > minVal && dropDownAmount <= maxVal) {
                        $("#giftCardAmtErr").empty();
                        $("#missingFields").empty();
                        $("#giftCardAmtErr").hide();
                        $("#missingFields").hide();
                        $("#giftCardForm").submit();
                    } else {
                        var eval1 = $("#emptyInputAmtRange").val();
                        var eval2 = $("#emptyInputAmtDollar").val();
                        $("#giftCardAmtErr").html(eval1 + minVal + eval2 + maxVal).show();
                        errMsg = $("#missingtextAmount").val();
                        $("#missingFields").html(errMsg).show();
                        return false;
                    }
                }
            } else {
                $("#giftCardAmtErr").empty();
                $("#missingFields").empty();
                $("#giftCardAmtErr").hide();
                $("#missingFields").hide();
                $("#giftCardForm").submit();
            }
        }
    }
    $("#send_by_dropdown_detail").val("pleaseSelect");
    $("#giftCardAmountdetail").val("0");
    $("select#send_by_dropdown_detail").selectbox("detach");
    $("select#send_by_dropdown_detail").selectbox();
    $("select#giftCardAmountdetail").selectbox("detach");
    $("select#giftCardAmountdetail").selectbox();
}
$(document).on("click", "#addGiftItemToBag",
function(b) {
    b.preventDefault();
    fnAddGiftItemToBag();
});
function checkInventory() {
    var b = $("input#finalStatusMsg").val();
    if (b == "OutOfStock") {
        $("select.prodDisplaySelectDropdown").selectbox("disable");
    } else {
        $("select.prodDisplaySelectDropdown").selectbox("enable");
    }
}
function outfitCheckInventory() {
    $("div.outfit-item").each(function() {
        var d = jQuery(this).find($("input#qty_drop_finalProductId")).val();
        var b = "#outfitFinalStatusMsg_" + d;
        var c = $(b).val();
        if (c == "OutOfStock") {
            jQuery(this).find("select.outfit-item-select-qty").selectbox("disable");
        } else {
            jQuery(this).find("select.outfit-item-select-qty").selectbox("enable");
        }
    });
}
function InitSCrollpane(b) {
    setTimeout(function() {
        $("#mk_size_guide_content").jScrollPane({
            mouseWheelSpeed: 30
        });
        $("#mk_size_guide_content").find(".jspContainer").css("height", "400px !important");
    },
    b);
}
function outfitQuickViewCheckInventory() {
    $("div.detail_container1").each(function() {
        var d = jQuery(this).find($("input#qty_drop_finalProductId")).val();
        var b = "#outfitFinalStatusMsg_" + d;
        var c = $(b).val();
        if (c == "OutOfStock") {
            jQuery(this).find("select.prodDisplaySelectDropdown").selectbox("disable");
        } else {
            jQuery(this).find("select.prodDisplaySelectDropdown").selectbox("enable");
        }
    });
}
function outfitLargeQuickViewCheckInventory() {
    $("div.outfit-item").each(function() {
        var d = jQuery(this).find($("input#qty_drop_finalProductId")).val();
        var b = "#outfitFinalStatusMsg_" + d;
        var c = $(b).val();
        if (c == "OutOfStock") {
            jQuery(this).find("select.prodDisplaySelectDropdown").selectbox("disable");
        } else {
            jQuery(this).find("select.prodDisplaySelectDropdown").selectbox("enable");
        }
    });
}
function ismaxlength(c) {
    var b = c.getAttribute ? parseInt(c.getAttribute("maxlength")) : "";
    if (c.getAttribute && c.value.length > b) {
        c.value = c.value.substring(0, b);
    }
}
$(document).on("click", ".shipping_restriction_popup",
function(c) {
    c.preventDefault();
    c.stopPropagation();
    var b = $(this).attr("href");
    $.ajax({
        url: b,
        type: "POST",
        dataType: "html",
        success: function(d) {
            $(".shipping_restriction_popup_container").html(d);
            $(".shipping_restriction_popup_container").dialog({
                autoOpen: false,
                resizable: false,
                height: "auto",
                width: "300",
                modal: true
            });
            $(".shipping_restriction_popup_container").dialog("open");
        }
    });
});$("li.nav-item").each(function() {
    var c = jQuery(this).find($("input#topMenuCatDisplayName")).val();
    var b = $("input#breadCrumbCatDisplayName").val();
    if (c == b) {
        jQuery(this).addClass("deptSelected");
    }
    if (c == undefined && b == undefined) {
        jQuery(this).removeClass("deptSelected");
    }
});$(".share-links").mouseover(function() {
    $(".share-links").addClass("overActive");
});
function refreshShareSection() {
    $(".fave-share-product .share").mouseover(function(c) {
        var b = $(this).parent().find(".socialShareDetails");
        shareProductDetails(b);
        $(".share-links").fadeIn();
    });
}
$(".share-links").mouseleave(function() {
    $(".share-links").hide("fade", 500);
    $(".share-links").removeClass("overActive");
});
function shareProductDetails(c) {
    var f = c.find("#socialTitle").val();
    var e = c.find("#socialDescription").val();
    var h = c.find("#socialImageSrcUrl").val();
    var d = c.find("#socialProductId").val();
    var g = c.find("#socialProductUrl").val();
    if (e == "") {
        e = "Find the " + f + " at Michael Kors.";
    }
    if (g == "") {
        g = document.URL;
    }
    var b = c.find("#fromQuickView").val();
    shareProduct(f, e, h, d, g, b);
}
function checkSizeSelected() {
    var b = $("select#productSize").val();
    if (b == "") {
        b = $("select#productSize option").eq(1).val();
        $("input#sizeNotSelectedSkuId").val(b);
    }
}
$(document).on("click", "#productDetailsPageContainer #addToBag",
function(b) {
    if ($(".generalErrors.addToCart_GeneralErrors").css("display") == "block") {
        $("#productDetailsPageContainer #addToBag").attr("disabled", "disabled");
        $(".prodDisplaySelectDropdown").on("change",
        function() {
            $(".generalErrors.addToCart_GeneralErrors").css("display", "none");
            $("#productDetailsPageContainer #addToBag").removeAttr("disabled");
            $("#productDetailsPageContainer #addToBag").attr("enabled", "enabled");
        });
    }
});$(document).on("click", "#profileDetailsContainer .add_all",
function(b) {
    if ($(".addallcart-error").css("display") == "block") {
        $("#profileDetailsContainer .add_all").on("click",
        function(c) {
            c.preventDefault();
        });
    }
});$(document).on("click", "#productQuickviewModal #addToBag",
function(b) {
    if ($("#productQuickviewModal .generalErrors.addToCart_GeneralErrors").css("display") == "block") {
        $("#productQuickviewModal #addToBag").attr("disabled", "disabled");
        $(".prodDisplaySelectDropdown").on("change",
        function() {
            $("#productQuickviewModal .generalErrors.addToCart_GeneralErrors").css("display", "none");
            $("#productQuickviewModal #addToBag").removeAttr("disabled");
            $("#productQuickviewModal #addToBag").attr("enabled", "enabled");
        });
    }
});$(document).on("click", ".additemBag #addrelateditemBag",
function(b) {
    if ($("#profileDetailsContainer #errorValidateBoxForAll.addallcart-error").css("display") == "block") {}
});$("#addrelateditemBag,#addToBag").keypress(function(b) {
    if (b.keyCode == 13) {
        $(this).trigger("click");
    }
});$(".recommenedImages").keypress(function(b) {
    if (b.keyCode == 13) {
        location.href = $(this).find("a").attr("href");
    }
});$(".recommenedImages").attr("tabindex", "101");$(".add-to-bag-label-2").find(".changed_input").each(function() {
    $(this).attr("tabindex", "33");
});
function SetFocusToControlShop() {
    if ($("#contactCreationForm").length > 0) {
        var b = $("#country").attr("sb");
        var c = "sbHolder_" + b;
        $("#" + c).focus();
    }
}
function KeyboardSetting() {
    $(document).on("keydown", ":submit,:button",
    function(b) {
        if (b.keyCode === 13) {
            if (this.id === "addGiftItemToBag") {
                fnAddGiftItemToBag();
            } else {
                if (this.id === "cartCheckoutButton") {
                    return false;
                } else {
                    $(this).trigger("click");
                }
            }
        }
    });
    $("button").off("keydown");
    $("button").on("keydown",
    function(b) {
        if (b.keyCode === 13) {
            $(this).trigger("click");
        }
    });
} (function(b) {
    b.EndecaSearchSuggestor = function(e, d) {
        this._active = true;
        this._options = d;
        this._lastValue = "";
        this._element = e;
        this._container = b('<div class="' + this._options.containerClass + '"></>');
        this._timeOutId;
        this._hideTimeOutId;
        this._selectedIndex = -1;
        var c = this;
        b("body").append(this._container);
        e.keydown(function(f) {
            switch (f.keyCode) {
            case 38:
                if (c._active) {
                    c.moveToPrev();
                } else {
                    c.show();
                }
                break;
            case 40:
                if (c._active) {
                    c.moveToNext();
                } else {
                    c.show();
                }
                break;
            case 9:
                c.hide();
                break;
            case 13:
                if (c._active && c._selectedIndex != -1) {
                    f.preventDefault();
                    c.selectItem();
                    return false;
                }
                break;
            case 27:
                if (c._active) {
                    c.hide();
                }
                break;
            default:
                c.handleRequest();
            }
        });
        e.blur(function(f) {
            var g = function() {
                c.hide();
            };
            c._hideTimeOutId = setTimeout(g, 200);
        });
    };
    b.EndecaSearchSuggestor.prototype.moveToPrev = function() {
        if (this._selectedIndex == -1) {
            this._selectedIndex = 0;
        } else {
            if (this._selectedIndex == 0) {
                return;
            }
            this._selectedIndex--;
        }
        b(".dimResult", this._container).removeClass("selected");
        b(b(".dimResult", this._container).get(this._selectedIndex)).addClass("selected");
    };
    b.EndecaSearchSuggestor.prototype.moveToNext = function() {
        if (this._selectedIndex == -1) {
            this._selectedIndex = 0;
        } else {
            if (this._selectedIndex == b(".dimResult", this._container).size() - 1) {
                return;
            }
            this._selectedIndex++;
        }
        b(".dimResult", this._container).removeClass("selected");
        b(b(".dimResult", this._container).get(this._selectedIndex)).addClass("selected");
    };
    b.EndecaSearchSuggestor.prototype.selectItem = function() {
        if (this._selectedIndex == -1) {
            return;
        }
        var c = b("a", b(".dimResult", this._container).get(this._selectedIndex)).attr("href");
        document.location.href = c;
    };
    b.EndecaSearchSuggestor.prototype.hide = function() {
        this._container.hide();
        this._active = false;
    };
    b.EndecaSearchSuggestor.prototype.show = function() {
        if (this._container.is(":hidden")) {
            this.setPosition();
            this._container.show();
            this._active = true;
            this._selectedIndex = -1;
        }
    };
    b.EndecaSearchSuggestor.prototype.handleRequest = function() {
        var c = this;
        var d = function() {
            var e = b.trim(c._element.val());
            if (e != c._lastValue) {
                if (e.length >= c._options.minAutoSuggestInputLength) {
                    c.requestData();
                } else {
                    c.hide();
                }
            }
            c._lastValue = e;
        };
        if (this._timeOutId) {
            clearTimeout(this._timeOutId);
        }
        this._timeOutId = setTimeout(d, this._options.delay);
    };
    b.EndecaSearchSuggestor.prototype.requestData = function() {
        noajaxloader = true;
        var d = this;
        var c = b.ajax({
            url: d.composeUrl(),
            dataType: "json",
            async: true,
            success: function(e) {
                d.showSearchResult(e);
                noajaxloader = false;
            }
        });
    };
    b.EndecaSearchSuggestor.prototype.composeUrl = function() {
        var d = " ";
        var c = b.trim(this._element.val());
        d = this._options.autoSuggestServiceUrl;
        var g = $("#searchByCategory").val();
        var e = "/_/N-";
        if (g.indexOf(e) != -1) {
            var f = g.substr(g.indexOf(e) + 5, e.length + 1);
        } else {
            var f = "0";
        }
        if (d.indexOf("?") == -1) {
            d += "?";
        } else {
            d += "&";
        }
        c = encodeURIComponent(c);
        d += "Dy=0&N=" + f + "&Ntt=" + c + "*";
        return d;
    };
    b.EndecaSearchSuggestor.prototype.showSearchResult = function(d) {
        var c = this.processSearchResult(d);
        if (c != null) {
            this._container.html(c);
            this.bindEventHandler();
            this.show();
        } else {
            this.hide();
        }
    };
    b.EndecaSearchSuggestor.prototype.processSearchResult = function(d) {
        var e = d.records;
        var f = d.articles;
        var c = d.allRelatedArtclesUrl;
        if (e != null) {
            return this.generateHtmlContent(e, f, c, d);
        }
        return null;
    };
    b.EndecaSearchSuggestor.prototype.generateHtmlContent = function(w, E, q, I) {
        var l = b('<div id="addNewVal"></div>');
        if (w != null && w.length > 0) {
            var C = null;
            var n = false;
            var d = I.michaelkors;
            var y = I.viewdetail;
            if (!C) {
                if (E != null && E.length > 0) {
                    C = b('<section id="searchResults" class="newBorder"></div>');
                } else {
                    C = b('<section id="searchResults" ></div>');
                }
            }
            var G = w;
            for (var B = 0; B < G.length; B++) {
                var g = G[B];
                if (g != null) {
                    var H = g.attributes.scene7ImageUrl[0];
                    var z = g.attributes["product.displayName"][0];
                    var o = g.attributes["product.productSEOURL"][0];
                    var A = g.attributes.listPrice;
                    var f = g.attributes.salePrice;
                    if (f != 0) {
                        A = "<strike><div class='strike_price'>" + A + "</div></strike><div class='display_price PriceRed'>" + f + "</div>";
                    } else {
                        A = "<div class='strike_price'>" + A + "</div>";
                    }
                    C.append('<div class="result-item group"><img src="' + H + '"/><div class="result-item-info"><h3 class="result-item-product-name">' + d + "</br>" + this.highlightMatched(z) + '</h3><h4 class="result-item-product-price">' + A + '</h4><a href="' + this._options.searchProductUrl + o + '" onclick="typeAhead();">' + y + "</a><div></div>");
                }
            }
            l.append(C);
        }
        var c = null;
        var p;
        var D;
        var j;
        if (E != null && E.length > 0) {
            var J = E.length;
            c = b("");
            for (var B = 0; B < J; B++) {
                var t = E[B];
                if (t != null) {
                    var H = t.attributes["Article.imageurl"];
                    var m = t.attributes["Article.videoUrl"];
                    imageExists(H,
                    function(K) {
                        var L = b('<img src="' + H + '"');
                    });
                    p = '<img src="' + H + '" alt="featured article photo" title="" width="130" height="102">';
                    D = '<video width="130" height="102" style="float:right;" controls><source src="' + m + '" type="video/mp4"> <source src="' + m + '" type="video/ogg"></video>';
                    if (m != null) {
                        j = D;
                    } else {
                        j = p;
                    }
                    var F = t.attributes["Article.url"];
                    var e = t.attributes["Article.title"];
                    var h = t.attributes["Article.Description"];
                    var v = I.allrelatedkey;
                    var u = I.viewondestination;
                    var k = I.relatedarticle;
                    var r = I.inmichaelkors;
                    if (B == 0) {
                        c = b('<section id="searchRelatedArticles"><h2>' + k + '</h2><div id="searchFeaturedArticle">' + j + '<h3 class="headline">' + e + r + " </h3><h4>" + h + '</h4><a href="' + F + '">' + u + "</a></div><ul>");
                    } else {
                        c.append('<ul class="articleahead"><li><a href="' + F + '">' + t.attributes["Article.title"] + "</a></li></ul>");
                    }
                    if (B == (J - 1)) {
                        c.append('</ul><a href="' + q + '">' + v + "</a></section>");
                    }
                    l.append(c);
                }
            }
        }
        if (l != null) {
            return l[0];
        }
        return null;
    };
    b.EndecaSearchSuggestor.prototype.highlightMatched = function(h) {
        var g = b.trim(this._element.val()).toLowerCase();
        var d = h.toLowerCase();
        if (d.indexOf(g) != -1) {
            var c = d.indexOf(g);
            var e = h.substring(0, c);
            var f = h.substring(c + g.length);
            g = h.substr(c, g.length);
            d = e + "<span>" + g + "</span>" + f;
        }
        return d;
    };
    b.EndecaSearchSuggestor.prototype.bindEventHandler = function() {
        var c = this;
        b(".dimResult", this._container).mouseover(function(d) {
            b(".dimResult", c._container).removeClass("selected");
            b(this).addClass("selected");
            c._selectedIndex = b(".dimResult", c._container).index(b(this));
        });
        b(".dimResult", this._container).click(function(d) {
            c.selectItem();
        });
        b("a", b(".dimResult", this._container)).click(function(d) {
            d.preventDefault();
            c.selectItem();
        });
        b(".dimRoots", this._container).click(function() {
            clearTimeout(c._hideTimeOutId);
            c._element.focus();
        });
    };
    b.EndecaSearchSuggestor.prototype.setPosition = function() {
        var d = this._element.offset();
        var c = $("#searchByCategory").next(".sbHolder").offset();
        this._container.css({
            top: d.top + this._element.outerHeight() - 2,
            left: c.left,
            width: this._element.width()
        });
    };
    b.fn.endecaSearchSuggest = function(c) {
        var d = b.extend({},
        b.fn.endecaSearchSuggest.defaults, c);
        this.each(function() {
            var e = b(this);
            new b.EndecaSearchSuggestor(e, d);
        });
    };
    b.fn.endecaSearchSuggest.defaults = {
        minAutoSuggestInputLength: 3,
        displayImage: false,
        delay: 250,
        autoSuggestServiceUrl: "",
        collection: "",
        searchCategoryUrl: "/catalog",
        searchProductUrl: "",
        sourceCategoryName: "product.category",
        containerClass: "dimSearchSuggContainer",
        defaultImage: "no_image.gif"
    };
})(jQuery);
var s_account = $("#sAccountVar").val();
var s = s_gi(s_account);s.charSet = "ISO-8859-1";s.currencyCode = "USD";s.trackDownloadLinks = true;s.trackExternalLinks = true;s.trackInlineStats = true;s.linkDownloadFileTypes = "exe,zip,wav,mp3,mov,mpg,avi,wmv,pdf,doc,docx,xls,xlsx,ppt,pptx";s.linkInternalFilters = "javascript:,michaelkors.com";s.linkLeaveQueryString = false;s.linkTrackVars = "None";s.linkTrackEvents = "None";s.usePlugins = true;
function s_doPlugins(n) {
    if (n.events && n.events.indexOf("prodView") > -1) {
        n.events = n.apl(n.events, "event3", ",", 2);
    }
    n.prop6 = n.getPreviousValue(n.pageName, "gpv", "");
    if (n.events && n.events.indexOf("scAdd") > -1) {
        n.linkTrackVars = n.apl(n.linkTrackVars, "eVar9", ",", 2);
        if (n.prop6) {
            n.eVar9 = n.prop6;
        }
    }
    if (n.purchaseID) {
        n.eVar11 = n.purchaseID;
    }
    if (n.prop4) {
        n.eVar2 = n.prop4;
        n.events = n.apl(n.events, "event1", ",", 2);
        if (n.prop5 && (n.prop5 == "0" || n.prop5 == "zero")) {
            n.prop5 = "zero";
            n.events = n.apl(n.events, "event2", ",", 2);
        }
    }
    var j = n.getValOnce(n.eVar2, "s_stv", 0);
    if (j == "") {
        var l = n.split(n.events, ",");
        var k = "";
        for (var d = 0; d < l.length; d++) {
            if (l[d] == "event1" || l[d] == "event2") {
                continue;
            } else {
                k += l[d] ? l[d] + ",": l[d];
            }
        }
        n.events = k.substring(0, k.length - 1);
    }
    if (!n.eVar3) {
        n.eVar3 = n.getQueryParam("icid");
    }
    n.eVar3 = n.getValOnce(n.eVar3, "s_ev3", 0);
    n.visitstart = n.getVisitStart("s_vs");
    if (n.visitstart && n.visitstart == 1) {
        n.firstPage = "firstpage";
    }
    n.clickPast(n.firstPage, "event4", "event5");
    if (!n.campaign) {
        n.campaign = n.getQueryParam("ecid");
    }
    n.campaign = n.getValOnce(n.campaign, "s_campaign", 0);
    var m = false;
    if (document.referrer) {
        var c = n.split(n.linkInternalFilters, ",");
        var g = n.split(document.referrer, "/");
        g = g[2];
        for (var h in c) {
            if (g.indexOf(c[h]) > -1) {
                m = true;
            }
        }
    }
    if (n.campaign) {
        n.eVar1 = "external campaign referral";
        n.eVar2 = "non-search";
        n.eVar3 = "non-internal campaign";
        n.eVar4 = "non-browse";
        n.eVar5 = "D=v4";
        n.eVar6 = "D=v4";
        n.eVar7 = "non-cross sell";
        n.eVar8 = "D=v7";
    } else {
        if (document.referrer && !m) {
            n.eVar1 = "external natural referral";
            n.eVar2 = "non-search";
            n.eVar3 = "non-internal campaign";
            n.eVar4 = "non-browse";
            n.eVar5 = "D=v4";
            n.eVar6 = "D=v4";
            n.eVar7 = "non-cross sell";
            n.eVar8 = "D=v7";
        } else {
            if (n.eVar2 && n.eVar2 != "non-search") {
                n.eVar1 = "internal keyword search";
                n.eVar3 = "non-internal campaign";
                n.eVar4 = "non-browse";
                n.eVar5 = "D=v4";
                n.eVar6 = "D=v4";
                n.eVar7 = "non-cross sell";
                n.eVar8 = "D=v7";
            } else {
                if (n.eVar3 && n.eVar3 != "non-internal campaign") {
                    n.eVar1 = "internal campaign";
                    n.eVar2 = "non-search";
                    n.eVar4 = "non-browse";
                    n.eVar5 = "D=v4";
                    n.eVar6 = "D=v4";
                    n.eVar7 = "non-cross sell";
                    n.eVar8 = "D=v7";
                } else {
                    if (n.eVar4 && n.eVar4 != "non-browse") {
                        n.eVar1 = "browse";
                        n.eVar2 = "non-search";
                        n.eVar3 = "non-internal campaign";
                        if (!n.eVar5) {
                            n.eVar5 = n.eVar4;
                        }
                        if (!n.eVar6) {
                            n.eVar6 = n.eVar5;
                        }
                        n.eVar7 = "non-cross sell";
                        n.eVar8 = "D=v7";
                    } else {
                        if (n.eVar7 && n.eVar7 != "non-cross sell") {
                            if (n.products) {
                                n.newProduct = "true";
                            }
                            n.linkTrackVars = n.apl(n.linkTrackVars, "eVar1,eVar2,eVar3,eVar4,eVar5, eVar6", ",", 2);
                            n.eVar1 = "cross-sell";
                            n.eVar2 = "non-search";
                            n.eVar3 = "non-internal campaign";
                            n.eVar4 = "non-browse";
                            n.eVar5 = "D=v4";
                            n.eVar6 = "D=v4";
                            if (!n.eVar8) {
                                n.eVar8 = "unknown at time of cross-sell click";
                            }
                        } else {
                            if (n.events.indexOf("purchase") > -1) {
                                n.eVar1 = "unknown at time of purchase";
                                n.eVar2 = n.eVar3 = n.eVar4 = n.eVar5 = n.eVar6 = n.eVar7 = n.eVar8 = n.eVar9 = "D=v1";
                            } else {
                                if (n.eVar1) {
                                    n.eVar2 = "non-search";
                                    n.eVar3 = "non-internal campaign";
                                    n.eVar4 = "non-browse";
                                    n.eVar5 = "D=v4";
                                    n.eVar6 = "D=v4";
                                    n.eVar7 = "non-cross sell";
                                    n.eVar8 = "D=v7";
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    if (n.eVar1 && (!n.products || (n.products && n.products.indexOf(";productmerch") > -1) || n.newProduct == "true") && (n.p_fo("onemerch") == 1 || (n.linkType != "" && n.linkTrackVars.indexOf("eVar1") > -1))) {
        if (!n.c_r("productnum")) {
            n.productNum = 1;
        } else {
            n.productNum = parseInt(n.c_r("productnum")) + 1;
        }
        n.products = ";productmerch" + n.productNum;
        var k = new Date();
        k.setTime(k.getTime() + (30 * 86400000));
        n.c_w("productnum", n.productNum, k);
        n.linkTrackVars = n.apl(n.linkTrackVars, "events,products", ",", 2);
        n.linkTrackEvents = n.apl(n.linkTrackEvents, "event6", ",", 2);
        n.events = n.apl(n.events, "event6", ",", 2);
    }
    if (n.c_r("productnum") && n.events.indexOf("purchase") > -1) {
        n.c_w("productnum", "0", 0);
    }
    if (n.prop6) {
        n.prop7 = n.getPercentPageViewed();
    }
    n.eVar14 = n.getTimeParting("d", "-7") + " - " + n.getTimeParting("h", "-7");
    function b() {
        var o, f, r, p = document.cookie.split(";");
        for (o = 0; o < p.length; o++) {
            f = p[o].substr(0, p[o].indexOf("="));
            r = p[o].substr(p[o].indexOf("=") + 1);
            f = f.replace(/^\s+|\s+$/g, "");
            if (f == "s_vi") {
                var q = /[0-9A-F]+-[0-9A-F]+/g;
                var e = r.match(q);
                return unescape(e);
            }
        }
    }
    n.eVar22 = b();
    n.eVar10 = n.getNewRepeat(365);
}
s.doPlugins = s_doPlugins;
function s_crossSell() {
    s.linkTrackVars = "eVar7,eVar8,events,products";
    s.eVar7 = s.pageName;
    s.eVar8 = s.products ? s.products.substring(1) : "unknown at time of cross-sell click";
    s.tl(this, "o", "cross-sell");
}
s.crossVisitParticipation = new Function("v", "cn", "ex", "ct", "dl", "ev", "dv", "var s=this,ce;if(typeof(dv)==='undefined')dv=0;if(s.events&&ev){var ay=s.split(ev,',');var ea=s.split(s.events,',');for(var u=0;u<ay.length;u++){for(var x=0;x<ea.length;x++){if(ay[u]==ea[x]){ce=1;}}}}if(!v||v==''){if(ce){s.c_w(cn,'');return'';}else return'';}v=escape(v);var arry=new Array(),a=new Array(),c=s.c_r(cn),g=0,h=new Array();if(c&&c!=''){arry=s.split(c,'],[');for(q=0;q<arry.length;q++){z=arry[q];z=s.repl(z,'[','');z=s.repl(z,']','');z=s.repl(z,\"'\",'');arry[q]=s.split(z,',')}}var e=new Date();e.setFullYear(e.getFullYear()+5);if(dv==0&&arry.length>0&&arry[arry.length-1][0]==v)arry[arry.length-1]=[v,new Date().getTime()];else arry[arry.length]=[v,new Date().getTime()];var start=arry.length-ct<0?0:arry.length-ct;var td=new Date();for(var x=start;x<arry.length;x++){var diff=Math.round((td.getTime()-arry[x][1])/86400000);if(diff<ex){h[g]=unescape(arry[x][0]);a[g]=[arry[x][0],arry[x][1]];g++;}}var data=s.join(a,{delim:',',front:'[',back:']',wrap:\"'\"});s.c_w(cn,data,e);var r=s.join(h,{delim:dl});if(ce)s.c_w(cn,'');return r;");s.getValOnce = new Function("v", "c", "e", "t", "var s=this,a=new Date,v=v?v:'',c=c?c:'s_gvo',e=e?e:0,i=t=='m'?60000:86400000;k=s.c_r(c);if(v){a.setTime(a.getTime()+e*i);s.c_w(c,v,e==0?0:a);}return v==k?'':v");s.getVisitStart = new Function("c", "var s=this,v=1,t=new Date;t.setTime(t.getTime()+1800000);if(s.c_r(c)){v=0}if(!s.c_w(c,1,t)){s.c_w(c,1,0)}if(!s.c_r(c)){v=0}return v;");s.clickPast = new Function("scp", "ct_ev", "cp_ev", "cpc", "var s=this,scp,ct_ev,cp_ev,cpc,ev,tct;if(s.p_fo(ct_ev)==1){if(!cpc){cpc='s_cpc';}ev=s.events?s.events+',':'';if(scp){s.events=ev+ct_ev;s.c_w(cpc,1,0);}else{if(s.c_r(cpc)>=1){s.events=ev+cp_ev;s.c_w(cpc,0,0);}}}");s.split = new Function("l", "d", "var i,x=0,a=new Array;while(l){i=l.indexOf(d);i=i>-1?i:l.length;a[x++]=l.substring(0,i);l=l.substring(i+d.length);}return a");s.getQueryParam = new Function("p", "d", "u", "h", "var s=this,v='',i,j,t;d=d?d:'';u=u?u:(s.pageURL?s.pageURL:s.wd.location);if(u=='f')u=s.gtfs().location;while(p){i=p.indexOf(',');i=i<0?p.length:i;t=s.p_gpv(p.substring(0,i),u+'',h);if(t){t=t.indexOf('#')>-1?t.substring(0,t.indexOf('#')):t;}if(t)v+=v?d+t:t;p=p.substring(i==p.length?i:i+1)}return v");s.p_gpv = new Function("k", "u", "h", "var s=this,v='',q;j=h==1?'#':'?';i=u.indexOf(j);if(k&&i>-1){q=u.substring(i+1);v=s.pt(q,'&','p_gvf',k)}return v");s.p_gvf = new Function("t", "k", "if(t){var s=this,i=t.indexOf('='),p=i<0?t:t.substring(0,i),v=i<0?'True':t.substring(i+1);if(p.toLowerCase()==k.toLowerCase())return s.epa(v)}return''");s.getNewRepeat = new Function("d", "cn", "var s=this,e=new Date(),cval,sval,ct=e.getTime();d=d?d:30;cn=cn?cn:'s_nr';e.setTime(ct+d*24*60*60*1000);cval=s.c_r(cn);if(cval.length==0){s.c_w(cn,ct+'-New',e);return'New';}sval=s.split(cval,'-');if(ct-sval[0]<30*60*1000&&sval[1]=='New'){s.c_w(cn,ct+'-New',e);return'New';}else{s.c_w(cn,ct+'-Repeat',e);return'Repeat';}");s.getPreviousValue = new Function("v", "c", "el", "var s=this,t=new Date,i,j,r='';t.setTime(t.getTime()+1800000);if(el){if(s.events){i=s.split(el,',');j=s.split(s.events,',');for(x in i){for(y in j){if(i[x]==j[y]){if(s.c_r(c)) r=s.c_r(c);v?s.c_w(c,v,t):s.c_w(c,'no value',t);return r}}}}}else{if(s.c_r(c)) r=s.c_r(c);v?s.c_w(c,v,t):s.c_w(c,'no value',t);return r}");s.handlePPVevents = new Function("", "var s=s_c_il[" + s._in + "];if(!s.getPPVid)return;var dh=Math.max(Math.max(s.d.body.scrollHeight,s.d.documentElement.scrollHeight),Math.max(s.d.body.offsetHeight,s.d.documentElement.offsetHeight),Math.max(s.d.body.clientHeight,s.d.documentElement.clientHeight)),vph=s.wd.innerHeight||(s.d.documentElement.clientHeight||s.d.body.clientHeight),st=s.wd.pageYOffset||(s.wd.document.documentElement.scrollTop||s.wd.document.body.scrollTop),vh=st+vph,pv=Math.min(Math.round(vh/dh*100),100),c=s.c_r('s_ppv'),a=(c.indexOf(',')>-1)?c.split(',',4):[],id=(a.length>0)?(a[0]):escape(s.getPPVid),cv=(a.length>1)?parseInt(a[1]):(0),p0=(a.length>2)?parseInt(a[2]):(pv),cy=(a.length>3)?parseInt(a[3]):(0),cn=(pv>0)?(id+','+((pv>cv)?pv:cv)+','+p0+','+((vh>cy)?vh:cy)):'';s.c_w('s_ppv',cn);");s.getPercentPageViewed = new Function("pid", "pid=pid?pid:'-';var s=this,ist=!s.getPPVid?true:false;if(typeof(s.linkType)!='undefined'&&s.linkType!='e')return'';var v=s.c_r('s_ppv'),a=(v.indexOf(',')>-1)?v.split(',',4):[];if(a.length<4){for(var i=3;i>0;i--){a[i]=(i<a.length)?(a[i-1]):('');}a[0]='';}a[0]=unescape(a[0]);s.getPPVpid=pid;s.c_w('s_ppv',escape(pid));if(ist){s.getPPVid=(pid)?(pid):(s.pageName?s.pageName:document.location.href);s.c_w('s_ppv',escape(s.getPPVid));if(s.wd.addEventListener){s.wd.addEventListener('load',s.handlePPVevents,false);s.wd.addEventListener('scroll',s.handlePPVevents,false);s.wd.addEventListener('resize',s.handlePPVevents,false);}else if(s.wd.attachEvent){s.wd.attachEvent('onload',s.handlePPVevents);s.wd.attachEvent('onscroll',s.handlePPVevents);s.wd.attachEvent('onresize',s.handlePPVevents);}}return(pid!='-')?(a):(a[1]);");s.getTimeParting = new Function("h", "z", "var s=this,od;od=new Date('1/1/2000');if(od.getDay()!=6||od.getMonth()!=0){return'Data Not Available';}else{var H,M,D,U,ds,de,tm,da=['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],d=new Date();z=z?z:0;z=parseFloat(z);if(s._tpDST){var dso=s._tpDST[d.getFullYear()].split(/,/);ds=new Date(dso[0]+'/'+d.getFullYear());de=new Date(dso[1]+'/'+d.getFullYear());if(h=='n'&&d>ds&&d<de){z=z+1;}else if(h=='s'&&(d>de||d<ds)){z=z+1;}}d=d.getTime()+(d.getTimezoneOffset()*60000);d=new Date(d+(3600000*z));H=d.getHours();M=d.getMinutes();M=(M<10)?'0'+M:M;D=d.getDay();U=' AM';if(H>=12){U=' PM';H=H-12;}if(H==0){H=12;}D=da[D];tm=H+':'+M+U;return(tm+'|'+D);}");s.getDaysSinceLastVisit = new Function("c", "var s=this,e=new Date(),es=new Date(),cval,cval_s,cval_ss,ct=e.getTime(),day=24*60*60*1000,f1,f2,f3,f4,f5;e.setTime(ct+3*365*day);es.setTime(ct+30*60*1000);f0='Cookies Not Supported';f1='First Visit';f2='More than 30 days';f3='More than 7 days';f4='Less than 7 days';f5='Less than 1 day';cval=s.c_r(c);if(cval.length==0){s.c_w(c,ct,e);s.c_w(c+'_s',f1,es);}else{var d=ct-cval;if(d>30*60*1000){if(d>30*day){s.c_w(c,ct,e);s.c_w(c+'_s',f2,es);}else if(d<30*day+1 && d>7*day){s.c_w(c,ct,e);s.c_w(c+'_s',f3,es);}else if(d<7*day+1 && d>day){s.c_w(c,ct,e);s.c_w(c+'_s',f4,es);}else if(d<day+1){s.c_w(c,ct,e);s.c_w(c+'_s',f5,es);}}else{s.c_w(c,ct,e);cval_ss=s.c_r(c+'_s');s.c_w(c+'_s',cval_ss,es);}}cval_s=s.c_r(c+'_s');if(cval_s.length==0) return f0;else if(cval_s!=f1&&cval_s!=f2&&cval_s!=f3&&cval_s!=f4&&cval_s!=f5) return '';else return cval_s;");s.getVisitNum = new Function("tp", "c", "c2", "var s=this,e=new Date,cval,cvisit,ct=e.getTime(),d;if(!tp){tp='m';}if(tp=='m'||tp=='w'||tp=='d'){eo=s.endof(tp),y=eo.getTime();e.setTime(y);}else {d=tp*86400000;e.setTime(ct+d);}if(!c){c='s_vnum';}if(!c2){c2='s_invisit';}cval=s.c_r(c);if(cval){var i=cval.indexOf('&vn='),str=cval.substring(i+4,cval.length),k;}cvisit=s.c_r(c2);if(cvisit){if(str){e.setTime(ct+1800000);s.c_w(c2,'true',e);return str;}else {return 'unknown visit number';}}else {if(str){str++;k=cval.substring(0,i);e.setTime(k);s.c_w(c,k+'&vn='+str,e);e.setTime(ct+1800000);s.c_w(c2,'true',e);return str;}else {s.c_w(c,e.getTime()+'&vn=1',e);e.setTime(ct+1800000);s.c_w(c2,'true',e);return 1;}}");s.dimo = new Function("m", "y", "var d=new Date(y,m+1,0);return d.getDate();");s.endof = new Function("x", "var t=new Date;t.setHours(0);t.setMinutes(0);t.setSeconds(0);if(x=='m'){d=s.dimo(t.getMonth(),t.getFullYear())-t.getDate()+1;}else if(x=='w'){d=7-t.getDay();}else {d=1;}t.setDate(t.getDate()+d);return t;");s.getTimeToComplete = new Function("v", "cn", "e", "var s=this,d=new Date,x=d,k;if(!s.ttcr){e=e?e:0;if(v=='start'||v=='stop')s.ttcr=1;x.setTime(x.getTime()+e*86400000);if(v=='start'){s.c_w(cn,d.getTime(),e?x:0);return '';}if(v=='stop'){k=s.c_r(cn);if(!s.c_w(cn,'',d)||!k)return '';v=(d.getTime()-k)/1000;var td=86400,th=3600,tm=60,r=5,u,un;if(v>td){u=td;un='days';}else if(v>th){u=th;un='hours';}else if(v>tm){r=2;u=tm;un='minutes';}else{r=.2;u=1;un='seconds';}v=v*r/u;return (Math.round(v)/r)+' '+un;}}return '';");s.setupFormAnalysis = new Function("var s=this;if(!s.fa){s.fa=new Object;var f=s.fa;f.ol=s.wd.onload;s.wd.onload=s.faol;f.uc=s.useCommerce;f.vu=s.varUsed;f.vl=f.uc?s.eventList:'';f.tfl=s.trackFormList;f.fl=s.formList;f.va=new Array('','','','')}");s.sendFormEvent = new Function("t", "pn", "fn", "en", "var s=this,f=s.fa;t=t=='s'?t:'e';f.va[0]=pn;f.va[1]=fn;f.va[3]=t=='s'?'Success':en;s.fasl(t);f.va[1]='';f.va[3]='';");s.faol = new Function("e", "var s=s_c_il[" + s._in + "],f=s.fa,r=true,fo,fn,i,en,t,tf;if(!e)e=s.wd.event;f.os=new Array;if(f.ol)r=f.ol(e);if(s.d.forms&&s.d.forms.length>0){for(i=s.d.forms.length-1;i>=0;i--){fo=s.d.forms[i];fn=fo.name;tf=f.tfl&&s.pt(f.fl,',','ee',fn)||!f.tfl&&!s.pt(f.fl,',','ee',fn);if(tf){f.os[fn]=fo.onsubmit;fo.onsubmit=s.faos;f.va[1]=fn;f.va[3]='No Data Entered';for(en=0;en<fo.elements.length;en++){el=fo.elements[en];t=el.type;if(t&&t.toUpperCase){t=t.toUpperCase();if(t.indexOf('FIELDSET')<0){var md=el.onmousedown,kd=el.onkeydown,omd=md?md.toString():'',okd=kd?kd.toString():'';if(omd.indexOf('.fam(')<0&&okd.indexOf('.fam(')<0){el.s_famd=md;el.s_fakd=kd;el.onmousedown=s.fam;el.onkeydown=s.fam}}}}}}f.ul=s.wd.onunload;s.wd.onunload=s.fasl;}return r;");s.faos = new Function("e", "var s=s_c_il[" + s._in + "],f=s.fa,su;if(!e)e=s.wd.event;if(f.vu){s[f.vu]='';f.va[1]='';f.va[3]='';}su=f.os[this.name];return su?su(e):true;");s.fasl = new Function("e", "var s=s_c_il[" + s._in + "],f=s.fa,a=f.va,l=s.wd.location,ip=s.trackPageName,p=s.pageName;if(a[1]!=''&&a[3]!=''){a[0]=!p&&ip?l.host+l.pathname:a[0]?a[0]:p;if(!f.uc&&a[3]!='No Data Entered'){if(e=='e')a[2]='Error';else if(e=='s')a[2]='Success';else a[2]='Abandon'}else a[2]='';var tp=ip?a[0]+':':'',t3=e!='s'?':('+a[3]+')':'',ym=!f.uc&&a[3]!='No Data Entered'?tp+a[1]+':'+a[2]+t3:tp+a[1]+t3,ltv=s.linkTrackVars,lte=s.linkTrackEvents,up=s.usePlugins;if(f.uc){s.linkTrackVars=ltv=='None'?f.vu+',events':ltv+',events,'+f.vu;s.linkTrackEvents=lte=='None'?f.vl:lte+','+f.vl;f.cnt=-1;if(e=='e')s.events=s.pt(f.vl,',','fage',2);else if(e=='s')s.events=s.pt(f.vl,',','fage',1);else s.events=s.pt(f.vl,',','fage',0)}else{s.linkTrackVars=ltv=='None'?f.vu:ltv+','+f.vu}s[f.vu]=ym;s.usePlugins=false;var faLink=new Object();faLink.href='#';s.tl(faLink,'o','Form Analysis');s[f.vu]='';s.usePlugins=up}return f.ul&&e!='e'&&e!='s'?f.ul(e):true;");s.fam = new Function("e", "var s=s_c_il[" + s._in + "],f=s.fa;if(!e) e=s.wd.event;var o=s.trackLastChanged,et=e.type.toUpperCase(),t=this.type.toUpperCase(),fn=this.form.name,en=this.name,sc=false;if(document.layers){kp=e.which;b=e.which}else{kp=e.keyCode;b=e.button}et=et=='MOUSEDOWN'?1:et=='KEYDOWN'?2:et;if(f.ce!=en||f.cf!=fn){if(et==1&&b!=2&&'BUTTONSUBMITRESETIMAGERADIOCHECKBOXSELECT-ONEFILE'.indexOf(t)>-1){f.va[1]=fn;f.va[3]=en;sc=true}else if(et==1&&b==2&&'TEXTAREAPASSWORDFILE'.indexOf(t)>-1){f.va[1]=fn;f.va[3]=en;sc=true}else if(et==2&&kp!=9&&kp!=13){f.va[1]=fn;f.va[3]=en;sc=true}if(sc){nface=en;nfacf=fn}}if(et==1&&this.s_famd)return this.s_famd(e);if(et==2&&this.s_fakd)return this.s_fakd(e);");s.ee = new Function("e", "n", "return n&&n.toLowerCase?e.toLowerCase()==n.toLowerCase():false;");s.fage = new Function("e", "a", "var s=this,f=s.fa,x=f.cnt;x=x?x+1:1;f.cnt=x;return x==a?e:'';");s.p_fo = new Function("n", "var s=this;if(!s.__fo){s.__fo=new Object;}if(!s.__fo[n]){s.__fo[n]=new Object;return 1;}else {return 0;}");
if (!s.__ccucr) {
    s.c_rr = s.c_r;
    s.__ccucr = true;
    function c_r(g) {
        var j = this,
        n = new Date,
        f = j.c_rr(g),
        o = j.c_rspers(),
        h,
        b,
        l;
        if (f) {
            return f;
        }
        g = j.ape(g);
        h = o.indexOf(" " + g + "=");
        o = h < 0 ? j.c_rr("s_sess") : o;
        h = o.indexOf(" " + g + "=");
        b = h < 0 ? h: o.indexOf("|", h);
        l = h < 0 ? h: o.indexOf(";", h);
        b = b > 0 ? b: l;
        f = h < 0 ? "": j.epa(o.substring(h + 2 + g.length, b < 0 ? o.length: b));
        return f;
    }
    function c_rspers() {
        var d = s.c_rr("s_pers");
        var f = new Date().getTime();
        var b = null;
        var h = [];
        var e = "";
        if (!d) {
            return e;
        }
        h = d.split(";");
        for (var g = 0,
        c = h.length; g < c; g++) {
            b = h[g].match(/\|([0-9]+)$/);
            if (b && parseInt(b[1]) >= f) {
                e += h[g] + ";";
            }
        }
        return e;
    }
    s.c_rspers = c_rspers;
    s.c_r = c_r;
}
if (!s.__ccucw) {
    s.c_wr = s.c_w;
    s.__ccucw = true;
    function c_w(g, u, l) {
        var z = this,
        m = new Date,
        q = 0,
        f = "s_pers",
        b = "s_sess",
        p = 0,
        o = 0,
        w, r, n, h, y;
        m.setTime(m.getTime() - 60000);
        if (z.c_rr(g)) {
            z.c_wr(g, "", m);
        }
        g = z.ape(g);
        w = z.c_rspers();
        h = w.indexOf(" " + g + "=");
        if (h > -1) {
            w = w.substring(0, h) + w.substring(w.indexOf(";", h) + 1);
            p = 1;
        }
        r = z.c_rr(b);
        h = r.indexOf(" " + g + "=");
        if (h > -1) {
            r = r.substring(0, h) + r.substring(r.indexOf(";", h) + 1);
            o = 1;
        }
        m = new Date;
        if (l) {
            if (l.getTime() > m.getTime()) {
                w += " " + g + "=" + z.ape(u) + "|" + l.getTime() + ";";
                p = 1;
            }
        } else {
            r += " " + g + "=" + z.ape(u) + ";";
            o = 1;
        }
        r = r.replace(/%00/g, "");
        w = w.replace(/%00/g, "");
        if (o) {
            z.c_wr(b, r, 0);
        }
        if (p) {
            y = w;
            while (y && y.indexOf(";") != -1) {
                var j = parseInt(y.substring(y.indexOf("|") + 1, y.indexOf(";")));
                y = y.substring(y.indexOf(";") + 1);
                q = q < j ? j: q;
            }
            m.setTime(q);
            z.c_wr(f, w, m);
        }
        return u == z.c_r(z.epa(g));
    }
    s.c_w = c_w;
}
s.join = new Function("v", "p", "var s = this;var f,b,d,w;if(p){f=p.front?p.front:'';b=p.back?p.back:'';d=p.delim?p.delim:'';w=p.wrap?p.wrap:'';}var str='';for(var x=0;x<v.length;x++){if(typeof(v[x])=='object' )str+=s.join( v[x],p);else str+=w+v[x]+w;if(x<v.length-1)str+=d;}return f+str+b;");s.repl = new Function("x", "o", "n", "var i=x.indexOf(o),l=n.length;while(x&&i>=0){x=x.substring(0,i)+n+x.substring(i+o.length);i=x.indexOf(o,i+l)}return x");s.apl = new Function("l", "v", "d", "u", "var s=this,m=0;if(!l)l='';if(u){var i,n,a=s.split(l,d);for(i=0;i<a.length;i++){n=a[i];m=m||(u==1?(n==v):(n.toLowerCase()==v.toLowerCase()));}}if(!m)l=l?l+d+v:v;return l");s.visitorNamespace = $("#sVisitorNamespace").val();s.trackingServer = $("#sTrackingServer").val();s.trackingServerSecure = $("#sTrackingServerSecure").val();
var s_code = "",
s_objectID;
function s_gi(k, o, C) {
    var q="",
    y = window,
    f = y.s_c_il,
    b = navigator,
    A = b.userAgent,
    z = b.appVersion,
    p = z.indexOf("MSIE "),
    d = A.indexOf("Netscape6/"),
    t,
    h,
    g,
    r,
    B;
    if (k) {
        k = k.toLowerCase();
        if (f) {
            for (g = 0; g < 2; g++) {
                for (h = 0; h < f.length; h++) {
                    B = f[h];
                    r = B._c;
                    if ((!r || r == "s_c" || (g > 0 && r == "s_l")) && (B.oun == k || (B.fs && B.sa && B.fs(B.oun, k)))) {
                        if (B.sa) {
                            B.sa(k);
                        }
                        if (r == "s_c") {
                            return B;
                        }
                    } else {
                        B = 0;
                    }
                }
            }
        }
    }
    y.s_an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    y.s_sp = new Function("x", "d", "var a=new Array,i=0,j;if(x){if(x.split)a=x.split(d);else if(!d)for(i=0;i<x.length;i++)a[a.length]=x.substring(i,i+1);else while(i>=0){j=x.indexOf(d,i);a[a.length]=x.substring(i,j<0?x.length:j);i=j;if(i>=0)i+=d.length}}return a");
    y.s_jn = new Function("a", "d", "var x='',i,j=a.length;if(a&&j>0){x=a[0];if(j>1){if(a.join)x=a.join(d);else for(i=1;i<j;i++)x+=d+a[i]}}return x");
    y.s_rep = new Function("x", "o", "n", "return s_jn(s_sp(x,o),n)");
    y.s_d = new Function("x", "var t='`^@$#',l=s_an,l2=new Object,x2,d,b=0,k,i=x.lastIndexOf('~~'),j,v,w;if(i>0){d=x.substring(0,i);x=x.substring(i+2);l=s_sp(l,'');for(i=0;i<62;i++)l2[l[i]]=i;t=s_sp(t,'');d=s_sp(d,'~');i=0;while(i<5){v=0;if(x.indexOf(t[i])>=0) {x2=s_sp(x,t[i]);for(j=1;j<x2.length;j++){k=x2[j].substring(0,1);w=t[i]+k;if(k!=' '){v=1;w=d[b+l2[k]]}x2[j]=w+x2[j].substring(1)}}if(v)x=s_jn(x2,'');else{w=t[i]+' ';if(x.indexOf(w)>=0)x=s_rep(x,w,t[i]);i++;b+=62}}}return x");
    y.s_fe = new Function("c", "return s_rep(s_rep(s_rep(c,'\\\\','\\\\\\\\'),'\"','\\\\\"'),\"\\n\",\"\\\\n\")");
    y.s_fa = new Function("f", "var s=f.indexOf('(')+1,e=f.indexOf(')'),a='',c;while(s>=0&&s<e){c=f.substring(s,s+1);if(c==',')a+='\",\"';else if((\"\\n\\r\\t \").indexOf(c)<0)a+=c;s++}return a?'\"'+a+'\"':a");
    y.s_ft = new Function("c", "c+='';var s,e,o,a,d,q,f,h,x;s=c.indexOf('=function(');while(s>=0){s++;d=1;q='';x=0;f=c.substring(s);a=s_fa(f);e=o=c.indexOf('{',s);e++;while(d>0){h=c.substring(e,e+1);if(q){if(h==q&&!x)q='';if(h=='\\\\')x=x?0:1;else x=0}else{if(h=='\"'||h==\"'\")q=h;if(h=='{')d++;if(h=='}')d--}if(d>0)e++}c=c.substring(0,s)+'new Function('+(a?a+',':'')+'\"'+s_fe(c.substring(o+1,e))+'\")'+c.substring(e+1);s=c.indexOf('=function(')}return c;");
    q = s_d(q);
    if (p > 0) {
        t = parseInt(h = z.substring(p + 5));
        if (t > 3) {
            t = parseFloat(h);
        }
    } else {
        if (d > 0) {
            t = parseFloat(A.substring(d + 10));
        } else {
            t = parseFloat(z);
        }
    }
    if (t < 5 || z.indexOf("Opera") >= 0 || A.indexOf("Opera") >= 0) {
        q = s_ft(q);
    }
    if (!B) {
        B = new Object;
        if (!y.s_c_in) {
            y.s_c_il = new Array;
            y.s_c_in = 0;
        }
        B._il = y.s_c_il;
        B._in = y.s_c_in;
        B._il[B._in] = B;
        y.s_c_in++;
    }
    B._c = "s_c"; (new Function("s", "un", "pg", "ss", q))(B, k, o, C);
    return B;
}
function s_giqf() {
    var b = window,
    f = b.s_giq,
    d, c, e;
    if (f) {
        for (d = 0; d < f.length; d++) {
            c = f[d];
            e = s_gi(c.oun);
            e.sa(c.un);
            e.setTagContainer(c.tagContainerName);
        }
    }
    b.s_giq = 0;
}
s_giqf();
var s_account = $("#sAccountVar").val();
function checkoutInitiated(b) {
    if (typeof s_gi != "undefined") {
        var c = s_gi(s_account);
        c.linkTrackVars = "eVar30,events";
        c.linkTrackEvents = c.events = "scCheckout";
        c.eVar30 = b;
        c.tl(this, "o", "Checkout Initiated");
    }
}
function findInStoreOmniture() {
    if (typeof s_gi != "undefined") {
        var b = s_gi(s_account);
        b.linkTrackVars = "events";
        b.linkTrackEvents = b.events = "event23";
        b.tl(this, "o", "find in store");
    }
}
function loginPage(b) {
    if (typeof s_gi != "undefined") {
        var c = s_gi(s_account);
        c.linkTrackVars = "eVar20,eVar21,events";
        c.linkTrackEvents = "event7";
        c.eVar20 = "Member:MK";
        c.eVar21 = b;
        c.events = "event7";
        c.tl(this, "o", "Log In");
    }
}
function registrationPage() {
    if (typeof s_gi != "undefined") {
        var b = s_gi(s_account);
        b.linkTrackVars = "events";
        b.linkTrackEvents = b.events = "event28,event7";
        b.tl(this, "o", "registration page");
    }
}
function addmyfavorite(c) {
    if (typeof s_gi != "undefined") {
        var b = s_gi(s_account);
        b.linkTrackVars = "events,products";
        b.linkTrackEvents = b.events = "event24";
        b.products = ";" + c;
        b.tl(this, "o", "add to favorite");
    }
}
function emailSubscription() {
    if (typeof s_gi != "undefined") {
        var b = s_gi(s_account);
        b.linkTrackVars = "events";
        b.linkTrackEvents = b.events = "event26";
        b.tl(this, "o", "emailSubscription");
    }
}
function recommendation() {
    if (typeof s_gi != "undefined") {
        var b = s_gi(s_account);
        b.linkTrackVars = "events";
        b.linkTrackEvents = b.events = "event19";
        b.tl(this, "o", "recommendation");
    }
}
function searchRefineMent(d, b) {
    if (typeof s_gi != "undefined") {
        var c = s_gi(s_account);
        c.linkTrackVars = "eVar23,events";
        c.linkTrackEvents = c.events = "event20";
        c.eVar23 = b + ":" + d;
        c.tl(this, "o", "Search Refinement");
    }
}
function searchResultTab() {
    if (typeof s_gi != "undefined") {
        var b = s_gi(s_account);
        b.linkTrackVars = "prop8";
        b.prop8 = "products";
        b.tl(this, "o", "Search Results Tab");
    }
}
function typeAhead() {
    if (typeof s_gi != "undefined") {
        var b = s_gi(s_account);
        b.linkTrackVars = "events";
        b.linkTrackEvents = b.events = "event18";
        b.tl(this, "o", "typeAhead");
    }
}
function shareEmail(c) {
    if (typeof s_gi != "undefined") {
        var b = s_gi(s_account);
        b.linkTrackVars = "action,events,eVar26,products";
        b.linkTrackEvents = b.events = "event25";
        b.products = c;
        b.eVar26 = "Email to Friend";
        b.tl(this, "o", "socialSharing");
    }
}
function cartRemoval(c) {
    if (typeof s_gi != "undefined") {
        var b = s_gi(s_account);
        b.linkTrackEvents = "scRemove";
        b.linkTrackVars = "products,events";
        b.products = c;
        b.events = "scRemove";
        b.tl(this, "o", "Cart Removal");
    }
}
function quickViewOmni(c) {
    if (typeof s_gi != "undefined") {
        var b = s_gi(s_account);
        b.linkTrackEvents = "event21";
        b.linkTrackVars = "products,events";
        b.products = c;
        b.events = "event21";
        b.tl(this, "o", "Quickview");
    }
}
function addToCartOmni(c) {
    if (typeof s_gi != "undefined") {
        var b = s_gi(s_account);
        b.linkTrackVars = "eVar19,products,events";
        b.linkTrackEvents = "scAdd,scOpen";
        b.eVar19 = "Large";
        b.events = "scAdd,scOpen";
        b.products = c;
        b.tl(this, "o", "Add to Cart");
    }
}
function addToCartOmniScAdd(c) {
    if (typeof s_gi != "undefined") {
        var b = s_gi(s_account);
        b.linkTrackVars = "eVar19,products,events";
        b.linkTrackEvents = "scAdd";
        b.eVar19 = "Large";
        b.events = "scAdd";
        b.products = c;
        b.tl(this, "o", "Add to Cart");
    }
}
function colorChangeOmni(b, d) {
    if (typeof s_gi != "undefined") {
        var c = s_gi(s_account);
        c.linkTrackVars = "eVar25,events,products";
        c.linkTrackEvents = "event22";
        c.eVar25 = "color:" + b;
        c.events = "event22";
        c.products = d;
        c.tl(this, "o", "Change Color");
    }
}
function pdpOmniClick(c) {
    if (typeof s_gi != "undefined") {
        var b = s_gi(s_account);
        b.linkTrackVars = "eVar25,events";
        b.linkTrackEvents = "event22";
        b.eVar25 = "text:" + c;
        b.events = "event22";
        b.tl(this, "o", "Change text");
    }
}
$(function() {
    var c = $(window);
    var p = function() {
        return Math.round(m * 660 / 1440);
    },
    b = function() {
        m = Math.min(1440, c.width());
        e = p();
        carOffset = k - c.scrollTop() * 0.6;
        l();
    },
    o = function() {
        carOffset = k - c.scrollTop() * 0.6;
        $("#gleam").find(".gleam-slide").css({
            "background-position": "50% 0px"
        });
    },
    l = function() {
        $("#gleam").css({
            width: m + "px",
            height: e + "px"
        }).find(".gleam-slide").css({
            'background-size': m + "px " + e + "px",
            "background-position": "50% 0px",
            width: m + "px",
            height: e + "px"
        });
    },
    q = function() {
        h = Math.min(Math.max(0, h), $("#gleam").find(".gleam-slide").length - 1);
        var r = -h * m;
        clearTimeout(d);
        d = setTimeout(function() {
            $("#gleam").find(".gleam-slides").stop(true, true).animate({
                left: r + "px"
            },
            function() {
                var u = $("#gleam"),
                t = u.clone(true);
                u.before(t);
                $(".gleam:last").remove();
                $(".shine").removeClass("shine");
                $("#gleam").addClass("show-text").find(".gleam-slide").eq(h).find(".will-shine").addClass("shine");
            });
        },
        500);
        n();
    },
    f = function(t) {
        var r = t.pageX;
        if (r > m / 2) {
            $("#gleam").find(".carousel-next").addClass("show");
            $("#gleam").find(".carousel-prev").removeClass("show");
        } else {
            $("#gleam").find(".carousel-prev").addClass("show");
            $("#gleam").find(".carousel-next").removeClass("show");
        }
    },
    n = function() {
        if (h == 0) {
            $(".left-control").addClass("hide");
        } else {
            $(".left-control").removeClass("hide");
        }
        if (h == $("#gleam").find(".gleam-slide").length - 1) {
            $(".right-control").addClass("hide");
        } else {
            $(".right-control").removeClass("hide");
        }
    },
    k = 94,
    h = 0,
    m = 1440,
    e = p(),
    g = 0,
    d = null,
    j = $("#gleam").find("img");
    $.each(j,
    function(v, r) {
        var t = $(r),
        u = $(r).attr("src");
        t.closest(".gleam-slide").css("background-image", 'url("' + u + '")');
    });
    $(".right-control").on("click",
    function(r) {
        h += 1;
        q();
    });
    $(".left-control").on("click",
    function(r) {
        h -= 1;
        q();
    });
    c.on("resize", b).on("scroll", o);
    $("#gleam").on("mousemove", f);
    n();
    b();
    o();
});$(function() {
    var l, c, m, f, h, k, j, b, e, d = $(window);
    var g = $('<iframe id="PDPZOOM-View-iframe" name="PDPZOOM-View-iframe"   frameborder="0" marginwidth="0" marginheight="0" allowfullscreen seamless></iframe>');
    Defaults = function() {
        e = false;
        j = $(".productDetailFullSizeImage_cont a");
        $(document).on("click", "#xyz",
        function(n) {});
        $(document).on("touchstart", "#xyz",
        function(o) {
            var n = false;
            $(document).on("touchmove", "#xyz",
            function(p) {
                n = true;
            });
            setTimeout(function() {
                if (!n) {}
            },
            100);
        });
    };
    initialiseDialog = function() {
        Defaults();
        LogManager("**** LOG - Function Started ****");
        f = $("<div id='PDPZOOM-View'></div>").html(g).dialog({
            autoOpen: false,
            modal: true,
            resizable: false,
            width: "auto",
            height: "auto",
            close: function() {
                g.attr("src", "");
            }
        });
        LogManager("**** LOG - Dialog Box placed with id='PDPZOOM-View' & iframe='PDPZOOM-View-iframe' ****");
    };
    SetIframeDefaults = function() {
        l = "PDP Window";
        c = d.width() - 90;
        m = d.height();
        g.attr({
            width: +c,
            height: +m
        });
    };
    LoadingAnimation = function() {
        h = $("<div></div>").addClass("ajax_overlay_pdpzoom");
        k = $("<div></div>").addClass("ajax_loader_pdpzoom").add(h);
        g.contents().find("body").append(k);
    };
    OpenDialogWFrame = function(n) {
        n.preventDefault();
        if (n.target.tagName === "CANVAS" || n.target.tagName === "IMG") {
            b = $("#zoom_view").attr("href");
            SetIframeDefaults();
            f.dialog("open");
            LogManager("**** LOG - Dialog Box Initialiased and Opened ****");
            g.load(function() {
                LogManager("**** LOG - Iframe Loaded. Displaying Animation ****");
            });
            setTimeout(function() {
                LogManager("**** LOG - Animation Ended. ****");
                g.attr("src", b);
                LogManager("**** LOG - Iframe With URl Loaded. Function Completed. ****");
            },
            10);
            setTimeout(function() {
                g.contents().find("body").find(".ajax_overlay_pdpzoom").fadeOut();
                g.contents().find("body").find(".ajax_loader_pdpzoom").fadeOut();
            },
            2000);
        }
    };
    LogManager = function(n) {
        if (e) {
            if (n) {
                console.log(n);
            }
        }
    };
    d.on("load", initialiseDialog);
});