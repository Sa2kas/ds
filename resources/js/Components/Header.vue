<template>
    <div class="header">
        <div class="header-menu">
            <div class="leftLines" @click="toggleLeft">
                <div :class="showL ? 'activeLeft' : ''">
                    <span id="firstSpan" class="span"></span>
                    <span id="secondSpan" class="span"></span>
                    <span id="thirdSpan" class="span"></span>
                </div>
            </div>
        </div>
        <div class="header-logo">
            <img src="/images/logo2.png" alt="Logo" class="logo" />
        </div>
        <div class="header-actions">
            <div class="languages">
                <div class="language" @click="switchLanguage('lt')">LT</div>
                |
                <div class="language"  @click="switchLanguage('en')">EN</div>
            </div>
            <div class="login-logout">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route(`${$page.props.auth.user.role}.dashboard`)"
                    class="header-button"
                    >{{ $t('back_to_dashboard') }}</Link
                >

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="header-button"
                        >{{ t('log_in') }}</Link
                    >

                    <Link
                        :href="route('register')"
                        class="header-button"
                        >{{ t('register') }}</Link
                    >
                </template>
            </div>
        </div>
        <div class="showHideRight" @click="toggleRight">...</div>
        <div class="small-left-side">
            <div
                class="fixed-nav"
                :style="[
                    !showL ? { 'max-width': '0px', 'min-width': '0px' } : {},
                ]"
            >
                <LeftSide @close="closeSide" />
            </div>
        </div>
        <div
            class="small-right-side"
            :style="[!showR ? { 'max-width': '0px', 'min-width': '0px' } : {}]"
        >
            <RightSide />
        </div>
        <div
            class="menu-overlay"
            :style="[
                showR || showL ? { visibility: 'visible', opacity: '0.6' } : {},
            ]"
            @click="closeSide"
        />
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import LeftSide from "@/Components/LeftSide.vue";
import RightSide from "@/Components/RightSide.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n(); // Hook to access translations
const switchLanguage = (locale) => {
  window.location.href = route('lang.switch', { locale });
};

const showL = ref(false);
const showR = ref(false);

const toggleLeft = () => {
    showL.value = !showL.value;
    showR.value = false;
};

const toggleRight = () => {
    showR.value = !showR.value;
    showL.value = false;
};

const closeSide = () => {
    showR.value = false;
    showL.value = false;
};
</script>

<style scoped>
.header {
    background: linear-gradient(
        to top,
        rgba(255, 255, 255, 0) 0,
        rgba(255, 255, 255, 1) 10%,
        rgba(255, 255, 255, 1) 100%
    );
    color: #444;
    height: 70px;
    font-size: 16px;
    font-family: "Open Sans", sans-serif;
    display: flex;
    justify-content: space-between;
    padding: 0 1vw;
    z-index: 10;
    opacity: 0.975;
    position: fixed;
    top: 0;
    width: 100%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
.header-menu {
    width: 35%;
    display: flex;
}
.leftLines {
    margin-top: 25px;
    margin-left: 1vw;
    cursor: pointer;
    z-index: 5;
}
.span {
    background: rgba(68, 68, 68, 0.9);
    display: block;
    width: 25px;
    height: 2px;
    border-radius: 5px;
    margin-bottom: 5px;
    transition: all 0.2s linear;
}
.activeLeft .span:first-child {
    transform: translateY(5px) rotate(-45deg) scalex(1.3);
}
.activeLeft .span:nth-child(2) {
    height: 0;
    transition: all 0.05s linear;
}
.activeLeft .span:nth-child(3) {
    transform: translateY(-3px) rotate(45deg) scalex(1.3);
}
.header-logo {
    justify-content: end;
}
.logo {
    height: 60px;
    margin: 5px 0;
    float: right;
}
.header-actions {
    display: flex;
    justify-content: flex-end;
    padding-top: 20px;
    font-family: "Oswald", sans-serif;
    font-size: 16px;
    font-weight: 300;
    letter-spacing: 0.03em;
    width: 35%;
}
.languages {
    margin: 0 0.2em;
    display: flex;
}
.language {
    margin: 0 0.2em;
    cursor: pointer;
    height: 22px;
}
.login-logout {
    padding: 0 0.2em;
}
.header-button {
    border: 1.5px solid rgba(114, 59, 27, 0.5);
    border-radius: 5px;
    margin: 0 0.2em;
    padding: 0.2em 0.5em;
    text-transform: uppercase;
    color: #723b1b;
    background-color: #fff;
    font-size: 14px;
    font-family: "Oswald", sans-serif;
    font-weight: 300;
    letter-spacing: 0.02em;
}
.header-button:hover {
    border: 1.5px solid rgba(114, 59, 27, 0.7);
    box-shadow: 0 0 5px rgba(114, 59, 27, 0.2);
}
.showHideRight {
    display: none;
}
.small-left-side {
    position: fixed;
    z-index: 4;
    height: 100vh;
    display: flex;
}
.fixed-nav {
    height: calc(100vh - 70px); /* Adjusted to match header height */
    overflow: hidden;
    position: absolute;
    min-width: 350px;
    max-width: 350vw;
    transition: max-width 0.3s ease-in, min-width 0.3s ease-in;
    display: flex;
    top: 70px; /* Adjusted to match header height */
    left: -1vw;
}
.small-right-side {
    top: 70px; /* Adjusted to match header height */
    z-index: 1;
    transition: max-width 0.3s ease-in, min-width 0.3s ease-in;
    position: absolute;
    right: 0;
    justify-content: space-between;
    display: flex;
    height: calc(100vh - 70px); /* Adjusted to match header height */
    min-width: 300px;
    max-width: 300px;
    background: #f7f7f7;
}
.menu-overlay {
    transition: visibility 0.3s linear, opacity 0.3s linear;
    visibility: hidden;
    background: #000;
    opacity: 0;
    width: 100%;
    height: calc(100vh - 70px); /* Adjusted to match header height */
    display: block;
    top: 70px; /* Adjusted to match header height */
    left: 0;
    position: fixed;
}
@media only screen and (max-width: 800px) {
    .header-actions {
        display: none;
    }
    .showHideRight {
        display: block;
        transform: rotate(90deg);
        height: 10px;
        margin-top: 30px;
        width: fit-content;
        font-size: 30px;
        cursor: pointer;
    }
    .header-menu {
        width: 10%;
    }
    .header-logo {
        margin-right: 10vw;
    }
    .leftLines {
        margin-left: 2vw;
    }
}
</style>
