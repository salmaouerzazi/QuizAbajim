@extends(getTemplate() . '.panel.layouts.panel_layout')

@push('styles_top')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<style>
    #navbar22 {
        overflow-x: auto;
        white-space: nowrap;
        width: 94%;
        /* ensure your scrollable element has a defined width */
        margin-left: 10px;
    }

    .nav-pills {
        display: inline-block;
    }

    .nav-scroll {
        overflow-x: auto;
        white-space: nowrap;
    }

    .nav-scroll .nav-item {
        display: inline-block;
    }

    .scrollmenu {
        overflow: auto;
        white-space: nowrap;
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }

    .scrollmenu::-webkit-scrollbar {
        /* Chrome, Safari and Opera */
        display: none;
    }

    .scrollmenu a {
        display: inline-block;
        color: black;
        text-align: center;
        padding: 14px;
        text-decoration: none;
    }

    .scrollmenu a:hover {
        background-color: #43d477;
    }
</style>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=YouTube+Sans:wght@300..900&display=swap");
    @import url("https://fonts.googleapis.com/css?family=Roboto:300italic,400italic,500italic,700italic");


    div {
        margin: 0;
        padding: 0;
        border: 0;
        background: transparent;
    }

    ytd-watch-metadata {
        display: block;
        color: var(--yt-spec-text-primary);
    }

    ytd-watch-metadata.ytd-watch-flexy {
        margin-top: var(--ytd-margin-3x);
        margin-bottom: var(--ytd-margin-6x);
    }

    ytd-watch-flexy[cinematics-enabled] #below.ytd-watch-flexy {
        position: relative;
    }

    #primary.ytd-watch-flexy {
        padding-right: var(--ytd-margin-6x);
    }

    ytd-watch-flexy[flexy] #primary.ytd-watch-flexy {
        margin-left: var(--ytd-margin-6x);
        min-width: var(--ytd-watch-flexy-min-player-width);
        flex: 1;
        flex-basis: 0.000000001px;
    }

    ytd-watch-flexy[flexy][is-two-columns_][is-four-three-to-sixteen-nine-video_] #primary.ytd-watch-flexy {
        max-width: var(--ytd-watch-flexy-max-player-width);
        min-width: var(--ytd-watch-flexy-min-player-width);
    }

    ytd-watch-flexy:not([theater]):not([fullscreen]):not([no-top-margin]):not([reduced-top-margin]) #primary.ytd-watch-flexy {
        padding-top: var(--ytd-margin-6x);
    }

    #columns.ytd-watch-flexy {
        margin: 0 auto;
        display: flex;
        flex-direction: row;
    }

    ytd-watch-flexy[flexy] #columns.ytd-watch-flexy {
        max-width: calc(1280px + var(--ytd-watch-flexy-sidebar-width) + 3 * var(--ytd-margin-6x));
    }

    ytd-watch-flexy[flexy][is-two-columns_] #columns.ytd-watch-flexy {
        min-width: calc(var(--ytd-watch-flexy-min-player-height) * var(--ytd-watch-flexy-width-ratio)/var(--ytd-watch-flexy-height-ratio) + 3 * var(--ytd-margin-6x) + var(--ytd-watch-flexy-sidebar-min-width));
        justify-content: center;
    }

    ytd-watch-flexy {
        --ytd-watch-flexy-sidebar-width: 402px;
        --ytd-watch-flexy-sidebar-min-width: 300px;
        --ytd-watch-flexy-masthead-height: 56px;
        min-width: 0;
    }

    ytd-watch-flexy[flexy] {
        --ytd-watch-flexy-width-ratio: 16;
        --ytd-watch-flexy-height-ratio: 9;
        --ytd-watch-flexy-space-below-player: 136px;
        --ytd-watch-flexy-min-player-height: 240px;
        --ytd-watch-flexy-min-player-width: calc(var(--ytd-watch-flexy-min-player-height) * (var(--ytd-watch-flexy-width-ratio) / var(--ytd-watch-flexy-height-ratio)));
        --ytd-watch-flexy-max-player-width: calc((100vh - (var(--ytd-watch-flexy-masthead-height) + var(--ytd-margin-6x) + var(--ytd-watch-flexy-space-below-player))) * (var(--ytd-watch-flexy-width-ratio) / var(--ytd-watch-flexy-height-ratio)));
    }

    ytd-page-manager>.ytd-page-manager {
        flex: 1;
        flex-basis: 0.000000001px;
    }

    ytd-watch-flexy[flexy][flexy-enable-large-window-sizing][flexy-large-window_]:not([is-extra-wide-video_]) {
        --ytd-watch-flexy-min-player-height: 480px;
    }

    ytd-page-manager {
        display: block;
        overflow-y: auto;
        margin-top: var(--ytd-toolbar-height);
    }

    #page-manager.ytd-app {
        overflow-x: inherit;
        overflow-y: visible;
        margin-top: var(--ytd-masthead-height, var(--ytd-toolbar-height));
    }

    ytd-app:not([use-content-visibility]) #page-manager.ytd-app {
        display: flex;
        flex: 1;
        flex-basis: 0.000000001px;
    }

    ytd-app {
        background: var(--yt-spec-general-background-a);
        display: block;
        left: 0;
        min-height: 100%;
        position: absolute;
        right: 0;
        top: 0;
        scrollbar-color: var(--yt-spec-text-secondary) transparent;
    }

    ytd-app[darker-dark-theme] {
        background: var(--yt-spec-base-background);
    }

    body {
        padding: 0;
        margin: 0;
        overflow-y: scroll;
    }

    html {
        background-color: #f9f9f9 !important;
        -webkit-text-size-adjust: none;
        --yt-spec-base-background: #fff;
        --yt-spec-raised-background: #fff;
        --yt-spec-menu-background: #fff;
        --yt-spec-inverted-background: #0f0f0f;
        --yt-spec-additive-background: rgba(0, 0, 0, 0.05);
        --yt-spec-outline: rgba(0, 0, 0, 0.1);
        --yt-spec-text-primary: #030303;
        --yt-spec-text-primary-inverse: #fff;
        --yt-spec-text-secondary: #606060;
        --yt-spec-text-disabled: #909090;
        --yt-spec-call-to-action: #065fd4;
        --yt-spec-icon-inactive: #909090;
        --yt-spec-icon-disabled: #ccc;
        --yt-spec-touch-response: #000;
        --yt-spec-touch-response-inverse: #fff;
        --yt-spec-brand-link-text: #c00;
        --yt-spec-themed-blue: #065fd4;
        --yt-spec-static-brand-white: #fff;
        --yt-spec-static-overlay-text-primary: #fff;
        --yt-spec-static-overlay-text-secondary: rgba(255, 255, 255, 0.7);
        --yt-spec-static-overlay-text-disabled: rgba(255, 255, 255, 0.3);
        --yt-spec-static-overlay-button-secondary: rgba(255, 255, 255, 0.1);
        --yt-spec-brand-background-solid: #fff;
        --yt-spec-general-background-a: #f9f9f9;
        --yt-spec-general-background-b: #f1f1f1;
        --yt-spec-10-percent-layer: rgba(0, 0, 0, 0.1);
        --yt-spec-badge-chip-background: rgba(0, 0, 0, 0.05);
        --yt-spec-mono-filled-hover: #272727;
        --yt-spec-mono-tonal-hover: rgba(0, 0, 0, 0.1);
        --yt-spec-white-2: #f9f9f9;
        --yt-spec-grey-1: #ccc;
        --yt-spec-grey-5: #606060;
        --yt-spec-dark-blue: #065fd4;
        --yt-spec-black-pure-alpha-15: rgba(0, 0, 0, 0.15);
        --yt-deprecated-luna-black: hsl(0, 0%, 6.7%);
        --yt-deprecated-opalescence-soft-grey: hsl(0, 0%, 93.3%);
        --yt-deprecated-luna-black-opacity-lighten-1: hsla(0, 0%, 6.7%, 0.8);
        --yt-deprecated-luna-black-opacity-lighten-2: hsla(0, 0%, 6.7%, 0.6);
        --yt-deprecated-luna-black-opacity-lighten-3: hsla(0, 0%, 6.7%, 0.4);
        --yt-deprecated-opalescence-soft-grey-opacity-lighten-3: hsla(0, 0%, 93.3%, 0.4);
        --yt-deprecated-luna-black-opacity-lighten-4: hsla(0, 0%, 6.7%, 0.2);
        --yt-opalescence-dark-grey: hsl(0, 0%, 20%);
        --yt-live-chat-action-panel-background-color-transparent: hsla(0, 0%, 97%, 0.8);
        --yt-live-chat-primary-text-color: var(--yt-spec-text-primary);
        --yt-live-chat-secondary-text-color: var(--yt-deprecated-luna-black-opacity-lighten-2);
        --yt-live-chat-disabled-icon-button-color: var(--yt-deprecated-luna-black-opacity-lighten-4);
        --yt-live-chat-poll-primary-text-color: var(--yt-spec-static-overlay-text-primary);
        --yt-live-chat-poll-tertiary-text-color: var(--yt-spec-static-overlay-text-disabled);
        --ytd-toolbar-height: 56px;
        --ytd-margin-3x: 12px;
        --ytd-margin-6x: 24px;
        --yt-navbar-title-font-size: 1.8rem;
        --ytd-tab-system-font-size: var(--yt-tab-system-font-size, 1.4rem);
        --ytd-tab-system-font-weight: 500;
        --ytd-tab-system-letter-spacing: var(--yt-tab-system-letter-spacing, 0.007px);
        --ytd-tab-system-text-transform: uppercase;
        --ytd-scrollbar-width: 8px;
        scrollbar-color: var(--yt-spec-text-secondary) transparent;
    }

    html[darker-dark-theme] {
        background-color: #fff !important;
    }

    html:not(.style-scope) {
        --primary-color: #3f51b5;
        --light-theme-background-color: #fff;
        --light-theme-text-color: #212121;
        --light-theme-secondary-color: #737373;
        --light-theme-disabled-color: #9b9b9b;
        --light-theme-divider-color: #dbdbdb;
        --dark-theme-text-color: #fff;
    }

    html[system-icons] {
        --yt-spec-icon-inactive: #030303;
        --yt-spec-icon-disabled: #909090;
    }

    html[darker-dark-theme] {
        --yt-spec-text-primary: #0f0f0f;
        --yt-spec-text-primary-inverse: #fff;
    }

    html[darker-dark-theme-deprecate],
    [darker-dark-theme-deprecate] {
        --yt-spec-brand-background-solid: var(--yt-spec-raised-background);
        --yt-spec-general-background-a: var(--yt-spec-base-background);
        --yt-spec-general-background-b: var(--yt-spec-base-background);
        --yt-spec-badge-chip-background: var(--yt-spec-additive-background);
        --yt-spec-10-percent-layer: var(--yt-spec-outline);
    }

    html[typography-spacing] {
        --yt-subheadline-letter-spacing: 0.1px;
        --yt-link-letter-spacing: 0.25px;
        --yt-user-comment-letter-spacing: 0.2px;
        --yt-caption-letter-spacing: 0.35px;
        --yt-tab-system-letter-spacing: 0.5px;
    }

    html[typography] {
        --yt-navbar-title-line-height: 2.6rem;
        --yt-subheadline-line-height: 2.2rem;
        --yt-link-line-height: 2rem;
        --yt-user-comment-line-height: 2rem;
        --yt-caption-font-size: 1.2rem;
        --yt-caption-line-height: 1.8rem;
    }

    html:not(.style-scope) {
        --yt-icon-width: 40px;
        --yt-icon-height: 40px;
    }

    #top-row.ytd-watch-metadata {
        margin-top: -4px;
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
    }

    .item.ytd-watch-metadata {
        box-sizing: border-box;
        min-width: 350px;
        margin-right: 12px;
        margin-top: 12px;
    }

    #owner.ytd-watch-metadata {
        display: flex;
        flex: 1;
        flex-basis: 0.000000001px;
        min-width: calc(50% - 6px);
        flex-basis: 0.000000001px;
        flex-direction: row;
        align-items: center;
    }

    #actions.ytd-watch-metadata {
        margin-right: 0;
        min-width: calc(50% - 6px);
        align-items: center;
        display: flex;
        flex-direction: row;
    }

    ytd-watch-metadata[flex-menu-enabled] #actions.ytd-watch-metadata {
        flex: 1 1 auto;
    }

    ytd-video-owner-renderer {
        display: flex;
        flex-direction: row;
    }

    ytd-video-owner-renderer[watch-metadata-refresh] {
        min-width: 0;
    }

    #actions-inner.ytd-watch-metadata {
        display: flex;
        flex-direction: column;
    }

    ytd-watch-metadata[flex-menu-enabled] #actions-inner.ytd-watch-metadata {
        width: 100%;
    }

    .yt-simple-endpoint {
        display: inline-block;
        cursor: pointer;
        text-decoration: none;
        color: var(--yt-endpoint-color, var(--yt-spec-text-primary));
    }

    .yt-simple-endpoint.ytd-video-owner-renderer {
        display: inline-block;
        cursor: pointer;
        text-decoration: none;
        color: var(--yt-endpoint-color, var(--yt-spec-text-primary));
    }

    .yt-simple-endpoint:hover {
        color: var(--yt-endpoint-hover-color, var(--yt-spec-text-primary));
        -webkit-text-decoration: var(--yt-endpoint-text-decoration, none);
        text-decoration: var(--yt-endpoint-text-decoration, none);
    }

    .yt-simple-endpoint.ytd-video-owner-renderer:hover {
        color: var(--yt-endpoint-hover-color, var(--yt-spec-text-primary));
        -webkit-text-decoration: var(--yt-endpoint-text-decoration, none);
        text-decoration: var(--yt-endpoint-text-decoration, none);
    }

    #upload-info.ytd-video-owner-renderer {
        flex: 1;
        flex-basis: 0.000000001px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    ytd-video-owner-renderer[watch-metadata-refresh] #upload-info.ytd-video-owner-renderer {
        margin-right: 24px;
        overflow: hidden;
    }

    [hidden] {
        display: none !important;
    }

    ytd-subscribe-button-renderer {
        display: flex;
        flex-direction: row;
    }

    yt-img-shadow {
        display: inline-block;
        opacity: 0;
        transition: opacity 0.2s;
        flex: none;
    }

    yt-img-shadow.no-transition {
        opacity: 1;
        transition: none;
    }

    yt-img-shadow[loaded] {
        opacity: 1;
    }

    #avatar.ytd-video-owner-renderer {
        margin-right: 12px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: transparent;
        overflow: hidden;
    }

    ytd-channel-name {
        z-index: 300;
        display: flex;
        align-self: flex-start;
    }

    #channel-name.ytd-video-owner-renderer {
        color: var(--yt-endpoint-color, var(--yt-spec-text-primary));
        display: flex;
        flex-direction: row;
        font-family: "Roboto", "Arial",  "Tajawal, sans-serif";
        font-size: 1.6rem;
        line-height: 2.2rem;
        font-weight: 500;
    }

    ytd-video-owner-renderer[watch-metadata-refresh] #channel-name.ytd-video-owner-renderer {
        max-width: 100%;
    }

    #owner-sub-count.ytd-video-owner-renderer {
        color: var(--yt-spec-text-secondary);
        margin-right: 4px;
        font-family: "Roboto", "Arial",  "Tajawal, sans-serif";

    }

    ytd-video-owner-renderer[watch-metadata-refresh] #owner-sub-count.ytd-video-owner-renderer {
        font-family: "Roboto", "Arial",  "Tajawal, sans-serif";
        font-size: 1.2rem;
        line-height: 1.8rem;
        font-weight: 400;
        overflow: hidden;
        display: box;
        max-height: 1.8rem;
        -webkit-line-clamp: 1;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        text-overflow: ellipsis;
        white-space: normal;
    }

    yt-formatted-string:-webkit-scrollbar {
        width: var(--ytd-scrollbar-width);
    }

    yt-formatted-string:-webkit-scrollbar-thumb {
        height: 56px;
        background: var(--yt-spec-icon-disabled);
    }

    yt-smartimation.ytd-subscribe-button-renderer {
        max-width: 100%;
    }

    ytd-menu-renderer {
        display: flex;
        flex-direction: row;
    }

    ytd-menu-renderer[has-flexible-items] {
        width: 100%;
        max-height: var(--yt-icon-height);
        overflow-y: hidden;
        flex-wrap: wrap;
    }

    ytd-watch-metadata[flex-menu-enabled] #actions.ytd-watch-metadata ytd-menu-renderer.ytd-watch-metadata {
        justify-content: flex-end;
    }

    img {
        margin: 0;
        padding: 0;
        border: 0;
        background: transparent;
    }

    img.yt-img-shadow {
        display: block;
        margin-left: var(--yt-img-margin-left, auto);
        margin-right: var(--yt-img-margin-right, auto);
        max-height: var(--yt-img-max-height, none);
        max-width: var(--yt-img-max-width, 100%);
        border-radius: var(--yt-img-border-radius, none);
    }

    #container.ytd-channel-name {
        display: var(--ytd-channel-name-container-display, inline-block);
        overflow: hidden;
        max-width: 100%;
    }

    ytd-badge-supported-renderer {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    ytd-badge-supported-renderer.ytd-channel-name {
        display: var(--ytd-channel-name-badges-display, flex);
        margin-right: var(--ytd-channel-name-badges-margin-right);
    }

    yt-button-shape {
        display: flex;
        flex: 1;
        flex-basis: 0.000000001px;
    }

    yt-button-shape.ytd-subscribe-button-renderer {
        max-width: 100%;
        flex: none;
    }

    .top-level-buttons.ytd-menu-renderer {
        display: flex;
        flex-direction: row;
    }

    yt-icon-button {
        display: inline-block;
        position: relative;
        width: 24px;
        height: 24px;
        box-sizing: border-box;
        font-size: 0;
    }

    .ytd-menu-renderer[style-target="button"] {
        --yt-icon-button-icon-width: 24px;
        --yt-icon-button-icon-height: 24px;
        width: var(--yt-icon-width);
        height: var(--yt-icon-height);
    }

    #top-level-buttons-computed.ytd-menu-renderer:not(:empty)+#flexible-item-buttons.ytd-menu-renderer+#button.ytd-menu-renderer {
        margin-left: 8px;
    }

    yt-button-shape.ytd-menu-renderer {
        flex: none;
    }

    ytd-menu-renderer[has-items] yt-button-shape.ytd-menu-renderer {
        margin-left: 8px;
    }

    #text-container.ytd-channel-name {
        display: var(--ytd-channel-name-text-container-display, block);
    }

    tp-yt-paper-tooltip {
        display: block;
        position: absolute;
        outline: none;
        z-index: 1002;
        -moz-user-select: none;
        -ms-user-select: none;
        -webkit-user-select: none;
        user-select: none;
        cursor: default;
    }

    tp-yt-paper-tooltip.ytd-channel-name {
        display: var(--yt-paper-tooltip-display);
    }

    .yt-spec-button-shape-next {
        position: relative;
        margin: 0;
        white-space: nowrap;
        min-width: 0;
        text-transform: none;
        font-family: "Roboto", "Arial",  "Tajawal, sans-serif";
        font-size: 14px;
        font-weight: 500;
        line-height: 18px;
        border: none;
        cursor: pointer;
        outline-width: 0;
        box-sizing: border-box;
        background: none;
        text-decoration: none;
        -webkit-tap-highlight-color: transparent;
        flex: 1;
        flex-basis: 0.000000001px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
    }

    .yt-spec-button-shape-next--size-m {
        padding: 0 16px;
        height: 36px;
        font-size: 14px;
        line-height: 36px;
        border-radius: 18px;
    }

    .yt-spec-button-shape-next--mono.yt-spec-button-shape-next--filled {
        color: var(--yt-spec-text-primary-inverse);
        background-color: var(--yt-spec-text-primary);
    }

    .yt-spec-button-shape-next--mono.yt-spec-button-shape-next--filled:hover {
        background-color: var(--yt-spec-mono-filled-hover);
        border-color: transparent;
    }

    ytd-segmented-like-dislike-button-renderer {
        display: flex;
    }

    ytd-button-renderer {
        display: inline-block;
    }

    ytd-menu-renderer:not([condensed]) .ytd-menu-renderer[button-renderer]+.ytd-menu-renderer[button-renderer] {
        margin-left: 8px;
    }

    ytd-download-button-renderer[is-hidden] {
        display: none;
    }

    #flexible-item-buttons.ytd-menu-renderer:not(:empty)>.ytd-menu-renderer[button-renderer] {
        margin-left: 8px;
    }

    ytd-menu-renderer:not([condensed]) .ytd-menu-renderer[button-renderer]+.ytd-menu-renderer[button-renderer],
    #flexible-item-buttons.ytd-menu-renderer:not(:empty)>.ytd-menu-renderer[button-renderer] {
        margin-left: 8px;
    }

    button.yt-icon-button {
        vertical-align: middle;
        color: inherit;
        outline: none;
        background: none;
        margin: 0;
        border: none;
        padding: 0;
        width: 100%;
        height: 100%;
        line-height: 0;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
    }

    yt-interaction {
        pointer-events: none;
        display: inline-block;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }

    .yt-spec-button-shape-next--icon-button {
        flex: none;
    }

    .yt-spec-button-shape-next--size-m.yt-spec-button-shape-next--icon-button {
        width: 36px;
        padding: 0;
    }

    .yt-spec-button-shape-next--mono.yt-spec-button-shape-next--tonal {
        color: var(--yt-spec-text-primary);
        background-color: var(--yt-spec-badge-chip-background);
    }

    .yt-spec-button-shape-next--mono.yt-spec-button-shape-next--tonal:hover {
        background-color: var(--yt-spec-mono-tonal-hover);
        border-color: transparent;
    }

    yt-formatted-string[ellipsis-truncate-styling] {
        display: block;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }

    yt-formatted-string[ellipsis-truncate-styling].complex-string {
        white-space: pre;
        display: flex;
        flex-direction: row;
    }

    #text.ytd-channel-name {
        display: var(--ytd-channel-name-text-display);
        -webkit-box-orient: vertical;
        -webkit-line-clamp: var(--ytd-channel-name-text-line-clamp, inherit);
        word-break: break-word;
        font-size: var(--ytd-channel-name-text-font-size);
        font-weight: var(--ytd-channel-name-text-font-weight);
        line-height: var(--ytd-channel-name-text-line-height);
    }

    #text.complex-string.ytd-channel-name {
        display: var(--ytd-channel-name-text-complex-display);
    }

    .hidden {
        display: none;
    }

    .tp-yt-paper-tooltip[style-target="tooltip"] {
        display: block;
        outline: none;
        font-family: "Roboto", "Noto",  "Tajawal, sans-serif";
        -webkit-font-smoothing: antialiased;
        font-size: 10px;
        line-height: 1;
        background-color: var(--paper-tooltip-background, #616161);
        color: var(--paper-tooltip-text-color, white);
        padding: 8px;
        border-radius: 2px;
    }

    .hidden.tp-yt-paper-tooltip {
        display: none !important;
    }

    tp-yt-paper-tooltip .tp-yt-paper-tooltip[style-target="tooltip"] {
        margin: 8px;
        text-transform: none;
        word-break: normal;
        font-family: "Roboto", "Arial",  "Tajawal, sans-serif";
        font-size: 1.2rem;
        line-height: 1.8rem;
        font-weight: 400;
    }

    body[rounded-container] tp-yt-paper-tooltip .tp-yt-paper-tooltip[style-target="tooltip"] {
        border-radius: 4px;
    }

    .yt-spec-button-shape-next--button-text-content {
        text-overflow: ellipsis;
        overflow: hidden;
    }

    yt-icon {
        display: inline-flexbox;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: relative;
        vertical-align: middle;
        fill: var(--iron-icon-fill-color, currentcolor);
        stroke: var(--iron-icon-stroke-color, none);
        width: var(--iron-icon-width, 24px);
        height: var(--iron-icon-height, 24px);
        -webkit-animation: var(--iron-icon-animation);
        animation: var(--iron-icon-animation);
        margin-top: var(--iron-icon-margin-top);
        margin-right: var(--iron-icon-margin-right);
        margin-bottom: var(--iron-icon-margin-bottom);
        margin-left: var(--iron-icon-margin-left);
        padding: var(--iron-icon-padding);
    }

    button.yt-icon-button>yt-icon {
        width: var(--yt-icon-button-icon-width, 100%);
        height: var(--yt-icon-button-icon-height, 100%);
    }

    #button.ytd-menu-renderer yt-icon.ytd-menu-renderer {
        color: var(--ytd-menu-renderer-button-color, var(--yt-spec-icon-inactive));
    }

    .stroke.yt-interaction {
        will-change: opacity;
        border: 1px solid var(--yt-spec-touch-response);
        opacity: 0;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }

    yt-interaction.circular .stroke.yt-interaction {
        border-radius: 50%;
    }

    .fill.yt-interaction {
        will-change: opacity;
        background-color: var(--yt-spec-touch-response);
        opacity: 0;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }

    yt-interaction.circular .fill.yt-interaction {
        border-radius: 50%;
    }

    .yt-spec-button-shape-next__icon {
        line-height: 0;
        fill: currentColor;
    }

    .yt-spec-button-shape-next--size-m .yt-spec-button-shape-next__icon {
        width: 24px;
        height: 24px;
    }

    a.yt-formatted-string {
        color: var(--yt-spec-call-to-action);
    }

    a.yt-simple-endpoint.yt-formatted-string {
        color: var(--yt-endpoint-color, var(--yt-spec-call-to-action));
        display: var(--yt-endpoint-display, inline-block);
        -webkit-text-decoration: var(--yt-endpoint-text-regular-decoration, none);
        text-decoration: var(--yt-endpoint-text-regular-decoration, none);
        word-wrap: var(--yt-endpoint-word-wrap, none);
        word-break: var(--yt-endpoint-word-break, none);
    }

    yt-formatted-string[ellipsis-truncate-styling] a.yt-formatted-string {
        display: block;
        margin-right: -0.1em;
        padding-right: 0.1em;
        white-space: pre;
    }

    yt-formatted-string[ellipsis-truncate-styling] a.yt-formatted-string:last-child {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    yt-formatted-string[has-link-only_]:not([force-default-style]) a.yt-simple-endpoint.yt-formatted-string {
        color: var(--yt-endpoint-color, var(--yt-spec-text-primary));
    }

    a.yt-simple-endpoint.yt-formatted-string:hover {
        color: var(--yt-endpoint-hover-color, var(--yt-spec-call-to-action));
        -webkit-text-decoration: var(--yt-endpoint-text-decoration, none);
        text-decoration: var(--yt-endpoint-text-decoration, none);
    }

    yt-formatted-string[has-link-only_]:not([force-default-style]) a.yt-simple-endpoint.yt-formatted-string:hover {
        color: var(--yt-endpoint-hover-color, var(--yt-spec-text-primary));
    }

    span {
        margin: 0;
        padding: 0;
        border: 0;
        background: transparent;
    }

    .yt-core-attributed-string--white-space-no-wrap {
        white-space: nowrap;
    }

    .yt-spec-touch-feedback-shape {
        display: inline-block;
        border-radius: inherit;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }

    ytd-toggle-button-renderer {
        display: inline-block;
        vertical-align: middle;
        font-size: var(--ytd-tab-system-font-size);
        font-weight: var(--ytd-tab-system-font-weight);
        letter-spacing: var(--ytd-tab-system-letter-spacing);
        text-transform: var(--ytd-tab-system-text-transform);
    }

    ytd-toggle-button-renderer:not([button-next]) {
        display: inline-block;
        text-transform: uppercase;
    }

    .yt-spec-touch-feedback-shape__stroke {
        will-change: opacity;
        opacity: 0;
        border-radius: inherit;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }

    .yt-spec-touch-feedback-shape--touch-response-inverse .yt-spec-touch-feedback-shape__stroke {
        border: 1px solid var(--yt-spec-touch-response-inverse);
    }

    .yt-spec-touch-feedback-shape__fill {
        will-change: opacity;
        opacity: 0;
        border-radius: inherit;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }

    .yt-spec-touch-feedback-shape--touch-response-inverse .yt-spec-touch-feedback-shape__fill {
        background-color: var(--yt-spec-touch-response-inverse);
    }

    .yt-spec-button-shape-next--size-m.yt-spec-button-shape-next--icon-leading-trailing .yt-spec-button-shape-next__icon {
        margin-right: 6px;
        margin-left: -6px;
    }

    .yt-spec-button-shape-next__secondary-icon {
        line-height: 0;
        fill: currentColor;
    }

    .yt-spec-button-shape-next--size-m.yt-spec-button-shape-next--icon-leading-trailing .yt-spec-button-shape-next__secondary-icon {
        margin-left: 6px;
        margin-right: -6px;
    }

    .yt-spec-button-shape-next--size-m.yt-spec-button-shape-next--icon-leading .yt-spec-button-shape-next__icon {
        margin-right: 6px;
        margin-left: -6px;
    }

    .yt-spec-touch-feedback-shape--touch-response .yt-spec-touch-feedback-shape__stroke {
        border: 1px solid var(--yt-spec-touch-response);
    }

    .yt-spec-touch-feedback-shape--touch-response .yt-spec-touch-feedback-shape__fill {
        background-color: var(--yt-spec-touch-response);
    }

    .yt-spec-button-shape-next--size-m.yt-spec-button-shape-next--segmented-start {
        border-radius: 18px 0 0 18px;
        position: relative;
    }

    .yt-spec-button-shape-next--size-m.yt-spec-button-shape-next--segmented-start:after {
        content: "";
        background: var(--yt-spec-10-percent-layer);
        position: absolute;
        right: 0;
        top: 6px;
        height: 24px;
        width: 1px;
    }

    .yt-spec-button-shape-next--size-m.yt-spec-button-shape-next--segmented-end {
        border-radius: 0 18px 18px 0;
    }

    .yt-spec-button-shape-next--size-m.yt-spec-button-shape-next--icon-button.yt-spec-button-shape-next--segmented-end {
        padding: 0 16px;
        width: 52px;
    }

    .yt-spec-button-shape-next--size-m.yt-spec-button-shape-next--icon-button.yt-spec-button-shape-next--segmented-end .yt-spec-button-shape-next__icon {
        margin-left: -6px;
    }

    yt-animated-icon {
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    ytd-lottie-player {
        display: block;
    }

    yt-animated-icon[animated-icon-type="LIKE"] ytd-lottie-player.yt-animated-icon {
        position: absolute;
        height: 62px;
        width: 62px;
        top: -18px;
    }

    .lottie-component {
        display: block;
    }


    /* These were inline style tags. Uses id+class to override almost everything */
    #avatar.style-oRzbr {
        background-color: transparent;
    }

    #style-OodnQ.style-OodnQ {}

    #style-jI9g2.style-jI9g2 {
        border-radius: inherit;
    }

    #style-EzHpd.style-EzHpd {}

    #style-yhVGc.style-yhVGc {}

    #style-FDeto.style-FDeto {}

    #style-TTmOL.style-TTmOL {
        width: 24px;
        height: 24px;
    }

    #style-ZgfDB.style-ZgfDB {
        width: 24px;
        height: 24px;
    }

    #style-jFHFU.style-jFHFU {
        border-radius: inherit;
    }

    #style-HiW8I.style-HiW8I {}

    #style-oIF9b.style-oIF9b {}

    #style-kTvf4.style-kTvf4 {}

    #style-mrGhA.style-mrGhA {
        width: 24px;
        height: 24px;
    }

    #style-qfHyH.style-qfHyH {
        display: none;
    }

    #style-Er2Vr.style-Er2Vr {
        display: none;
    }

    #style-i5DSN.style-i5DSN {
        display: none;
    }

    #style-q1x52.style-q1x52 {
        display: none;
    }

    #style-fLyjO.style-fLyjO {
        display: none;
    }

    #style-9FJNX.style-9FJNX {
        display: none;
    }

    #style-5jMLt.style-5jMLt {
        display: none;
    }

    #style-Bk5O1.style-Bk5O1 {
        display: none;
    }

    #style-QoAKo.style-QoAKo {
        display: none;
    }

    #style-sApd6.style-sApd6 {
        display: none;
    }

    #style-oxtPS.style-oxtPS {
        display: none;
    }

    #style-Omq33.style-Omq33 {
        display: block;
    }

    #style-k4rv1.style-k4rv1 {
        display: none;
    }

    #style-ktAHQ.style-ktAHQ {
        display: block;
    }

    #style-rh9o9.style-rh9o9 {
        display: none;
    }

    #style-WkWcg.style-WkWcg {
        display: block;
    }

    #style-sJPOz.style-sJPOz {
        border-radius: inherit;
    }

    #style-WXZYF.style-WXZYF {}

    #style-hES7I.style-hES7I {}

    #style-QQgZh.style-QQgZh {
        inset: 83.5px auto auto 599.664px;
    }

    #style-milm1.style-milm1 {}

    #style-hD9dO.style-hD9dO {
        width: 24px;
        height: 24px;
    }

    #style-ZPpbK.style-ZPpbK {
        border-radius: inherit;
    }

    #style-s53wU.style-s53wU {}

    #style-gsk9r.style-gsk9r {}

    #style-h5tZF.style-h5tZF {
        inset: 83.5px auto auto 644.969px;
    }

    #style-klbg6.style-klbg6 {}

    #style-2Levx.style-2Levx {
        width: 24px;
        height: 24px;
    }

    #style-84rEp.style-84rEp {
        border-radius: inherit;
    }

    #style-yO9s5.style-yO9s5 {}

    #style-MKkFH.style-MKkFH {}

    #style-roBep.style-roBep {}

    #style-iMyph.style-iMyph {
        width: 24px;
        height: 24px;
    }

    #style-UADgx.style-UADgx {
        border-radius: inherit;
    }

    #style-NRPos.style-NRPos {}

    #style-Z9hEz.style-Z9hEz {}

    #style-GKKaE.style-GKKaE {}

    #style-Bo2S6.style-Bo2S6 {
        width: 24px;
        height: 24px;
    }

    #style-TiGsh.style-TiGsh {
        border-radius: inherit;
    }

    #style-HAs52.style-HAs52 {}

    #style-G4F1h.style-G4F1h {}

    #style-8l8Rz.style-8l8Rz {}

    #style-QW6JW.style-QW6JW {
        width: 24px;
        height: 24px;
    }

    #style-b45qW.style-b45qW {
        border-radius: inherit;
    }

    #style-2Ukhx.style-2Ukhx {}

    #style-yLeOT.style-yLeOT {}

    .vGvPJe {
        align-items: center;
        flex-direction: row;
        box-sizing: border-box;
        display: flex;
        flex: 0 0 auto;
        border-radius: 8px;
        overflow: hidden;
    }

    .NqpkQc {
        background-color: rgba(0, 0, 0, 0.03);
        height: 100%;
        left: 0;
        pointer-events: none;
        position: absolute;
        top: 0;
        width: 100%;
    }

    .i5w0Le {
        color: #fff;
        left: 50%;
        opacity: 0.87;
        position: absolute;
        top: 46%;
        transform: translate(-50%, -50%);
    }

    .BQavlc {
        background-color: rgba(0, 0, 0, .54);
        border-radius: 4px;
        color: #fff;
        height: 14px;
        line-height: 14px;
        padding: 2px;
        position: absolute;
        width: 14px;
    }

    .BQavlc.w2wy2 {
        top: 8px;
        right: 8px;
    }

    .ZWiQ5 {
        bottom: 0;
        display: flex;
        flex-direction: column;
        left: 0;
        position: absolute;
        width: 100%;
    }

    .uOId3b {
        display: flex;
        align-items: start;
    }

    .X5OiLe:hover .uOId3b {
        text-decoration: underline;
    }

    .FzCfme {
        color: #70757a;
        margin-top: 0;
    }

    li {
        margin: 0;
        padding: 0;
    }

    ol li {
        list-style: none;
    }

    .z1asCe {
        display: inline-block;
        fill: currentColor;
        height: 24px;
        line-height: 24px;
        position: relative;
        width: 24px;
    }

    .lR1utd {
        display: flex;
        margin-bottom: 6px;
        position: relative;
        width: 100%;
        height: 18px;
    }

    .OSrXXb {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .ynAwRc {
        color: #1a0dab;
    }

    .fc9yUc {
        display: flex;
        flex-wrap: nowrap;
    }

    .tNxQIb {
        font-family: arial,  "Tajawal, sans-serif";
        font-size: 16px;
        font-weight: 400;
        line-height: 24px;
    }

    .pcJO7e {
        display: block;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 14px;
        line-height: 22px;
    }

    .hMJ0yc {
        color: #70757a;
        font-size: 14px;
    }

    .q9yZOe {
        width: 100%;
        height: 100%;
        display: inline-flex;
        flex-direction: column;
        border-right: 1px solid #dadce0;
    }

    .z1asCe svg {
        display: block;
        height: 100%;
        width: 100%;
    }

    .BQavlc.w2wy2 svg {
        transform: rotate(45deg);
    }

    .R4Cuhd {
        bottom: 0;
        display: flex;
        flex: 1;
        height: 16px;
        left: 8px;
        position: absolute;
    }

    .cHaqb {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    cite {
        color: #4d5156;
        font-style: normal;
    }

    .pcJO7e cite {
        font-size: 14px;
        line-height: 22px;
    }

    .V8fWH {
        border: 0;
        clip: rect(0 0 0 0);
        -webkit-clip-path: polygon(0 0, 0 0, 0 0);
        clip-path: polygon(0 0, 0 0, 0 0);
        height: 1px;
        margin: -1px;
        overflow: hidden;
        padding: 0;
        position: absolute;
        width: 1px;
        white-space: nowrap;
        -webkit-appearance: none;
        appearance: none;
        z-index: -1000;
        -webkit-user-select: none;
        user-select: none;
    }

    .J1mWY {
        background-color: rgba(0, 0, 0, .54);
        border-radius: 8px;
        color: #fff;
        font-family: arial,  "Tajawal, sans-serif"-medium,  "Tajawal, sans-serif";
        font-size: 12px;
        line-height: 14px;
        padding: 1px 8px;
        text-align: center;
    }


    /* These were inline style tags. Uses id+class to override almost everything */
    #style-o1LZl.style-o1LZl {
        border-radius: 8px;
    }

    #style-J4Lnt.style-J4Lnt {
        height: 35px;
        line-height: 35px;
        width: 35px;
    }

    #style-BrwYe.style-BrwYe {
        height: 14px;
        line-height: 14px;
        width: 14px;
    }

    #style-rRkDQ.style-rRkDQ {
        bottom: 0px;
        margin-left: 9px;
    }

    .RzdJxc {
        border-top: 1px solid #ecedef;
        position: relative;
    }

    .e4xoPb {
        position: relative;
        padding-bottom: 0;
    }

    .uVMCKf {
        overflow: visible;
        box-shadow: none;
        border: none;
        margin-top: 0;
        margin-bottom: 46px;
    }

    div.ULSxyf:first-of-type .uVMCKf {
        margin-top: 11px;
    }

    .ULSxyf {
        margin-bottom: 44px;
    }

    .v7W49e {
        margin-top: 6px;
    }

    .eqAnXb {
        font-size: medium;
        font-weight: normal;
    }

    .s6JM6d {
        width: var(--center-width);
        position: relative;
        margin-left: var(--center-abs-margin);
        flex: 0 auto;
    }

    .GyAeWb {
        display: flex;
        justify-content: flex-start;
        flex-wrap: wrap;
        max-width: calc(var(--center-abs-margin) + var(--center-width) + var(--rhs-margin) + var(--rhs-width));
    }

    .e9EfHf {
        font-family: arial,  "Tajawal, sans-serif";
        clear: both;
        margin-left: 0;
        padding-top: 20px;
        box-sizing: border-box;
        position: relative;
        min-height: 100vh;
    }

    video {

        background: transparent url('parrots.jpg') no-repeat 0 0;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }

    .main {
        min-width: calc(var(--center-abs-margin) + var(--center-width) + var(--rhs-margin) + var(--rhs-width));
        width: 100%;
    }

    body {
        font-family: arial,  "Tajawal, sans-serif";
        font-size: 14px;
        margin: 0;
        background: #fff;
        color: #202124;
    }

    .srp {
        --center-abs-margin: 180px;
        --center-width: 652px;
        --rhs-margin: 76px;
        --rhs-width: 372px;
    }

    @media (min-width: 1675px) {
        .srp {
            --center-abs-margin: 230px;
        }
    }

    html {
        font-family: arial,  "Tajawal, sans-serif";
    }

    g-scrolling-carousel {
        display: block;
        position: relative;
    }

    .Lzivkf {
        padding-bottom: 12px;
        position: relative;
    }

    .mR2gOd {
        display: block;
        overflow-x: auto;
        overflow-y: hidden;
        position: relative;
        white-space: nowrap;
        transform: translate3d(0, 0, 0);
    }

    .mR2gOd:-webkit-scrollbar {
        display: none;
    }

    .DAVP1 {
        display: inline-block;
    }

    .OZ5bRd {
        margin-bottom: auto;
        margin-top: auto;
    }

    .wgbRNb {
        cursor: pointer;
        height: 72px;
        position: absolute;
        display: block;
        visibility: inherit;
        width: 36px;
        bottom: 0;
        opacity: 0.8;
        top: 0;
        z-index: 101;
    }

    g-left-button {
        margin-top: 30px;
    }

    .wgbRNb.tHT0l {
        -webkit-transition: opacity 0.5s, visibility 0.5s;
        transition: opacity 0.5s, visibility 0.5s;
    }

    .wgbRNb.pQXcHc {
        cursor: default;
        opacity: 0;
        visibility: hidden;
    }

    .wgbRNb.T9Wh5 {
        height: 36px;
        width: 36px;
        opacity: 1;
    }

    .bCwlI.T9Wh5 {
        left: -18px;
    }

    .wgbRNb.T9Wh5.pQXcHc {
        opacity: 0;
    }

    g-right-button {
        margin-top: 30px;
    }

    .VdehBf.T9Wh5 {
        right: -18px;
    }

    ol {
        margin: 0;
        padding: 0;
    }

    .bc7Xde {
        border-radius: 8px;
        display: flex;
        margin-bottom: 4px;
        box-shadow: none;
    }

    .OvQkSb {
        border-radius: 999rem;
    }

    .CNf3nf {
        cursor: pointer;
        display: block;
        position: relative;
        border: 1px solid #dadce0;
        z-index: 0;
    }

    .LhCR5d {
        width: 40px;
        height: 40px;
    }

    .bCwlI.T9Wh5 g-fab {
        cursor: pointer;
        height: 36px;
        width: 36px;
    }

    .VdehBf.T9Wh5 g-fab {
        cursor: pointer;
        height: 36px;
        width: 36px;
    }

    li {
        margin: 0;
        padding: 0;
    }

    ol li {
        list-style: none;
    }

    .z1asCe {
        display: inline-block;
        fill: currentColor;
        height: 24px;
        line-height: 24px;
        position: relative;
        width: 24px;
    }

    .S3PB2d {
        margin: auto;
    }

    .CNf3nf .PUDfGe {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        width: 24px;
        height: 24px;
    }

    a {
        color: #1a0dab;
        text-decoration: none;
        -webkit-tap-highlight-color: rgba(0, 0, 0, .1);
    }

    .q9yZOe {
        width: 100%;
        height: 100%;
        display: inline-flex;
        flex-direction: column;
        border-right: 1px solid #dadce0;
    }

    html:not(.zAoYTe) [href] {
        outline: 0;
    }

    a:hover {
        text-decoration: underline;
    }

    .z1asCe svg {
        display: block;
        height: 100%;
        width: 100%;
    }

    .k8E1vb {
        border-radius: 8px;
        background-color: #dadce0;
        margin-bottom: 12px;

        height: 67px;
    }

    .oLJ4Uc {
        overflow: hidden;
    }

    .fYFvJb {
        display: grid;
        gap: 6px;
    }

    .IOZdEc {
        height: 100%;
    }

    .mNbAre {
        object-fit: cover;
    }

    .oLJ4Uc img {
        width: 100%;
        display: block;
    }

    .tVRLD {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        font-family: arial,  "Tajawal, sans-serif";
        font-size: 14px;
        line-height: 18px;
        white-space: normal;
        color: #1a0dab;
    }

    .paD5uf {
        white-space: normal;
        width: 100%;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 18px;
        max-height: 54px;
        font-family: arial,  "Tajawal, sans-serif";
        font-size: 14px;
        margin-top: 0;
        word-break: break-word;
        color: #3c4043;
    }


    /* These were inline style tags. Uses id+class to override almost everything */
    #_qXdVZJqbOJv-7_UPmvOKsAk_32.style-4V3fk {
        padding-top: 16px;
    }

    #style-ebBB1.style-ebBB1 {
        overflow-x: auto;
    }

    #style-JxznW.style-JxznW {
        border: none;
        width: 120px;
        padding-right: 12px;
        opacity: 1;
    }

    #style-ST9Kp.style-ST9Kp {
        height: 67px;
    }

    #style-N3U2Y.style-N3U2Y {
        border: none;
        width: 120px;
        padding-right: 12px;
        opacity: 1;
    }

    #style-VodIa.style-VodIa {
        height: 67px;
    }

    #style-oQd4Z.style-oQd4Z {
        border: none;
        width: 120px;
        padding-right: 12px;
        opacity: 1;
    }

    #style-WCyVT.style-WCyVT {
        height: 67px;
    }

    #style-d2o4t.style-d2o4t {
        border: none;
        width: 120px;
        padding-right: 12px;
        opacity: 1;
    }

    #style-Vc5bZ.style-Vc5bZ {
        height: 67px;
    }

    #style-VIP4d.style-VIP4d {
        border: none;
        width: 120px;
        padding-right: 12px;
        opacity: 1;
    }

    #style-Vz5nw.style-Vz5nw {
        height: 67px;
    }

    #tsuid_42.style-vgVaC {
        border: none;
        width: 84px;
        padding-right: 12px;
        opacity: 0.2;
    }

    #style-mUegq.style-mUegq {
        height: 67px;
    }

    #tsuid_44.style-BmsIp {
        border: none;
        width: 120px;
        padding-right: 12px;
        opacity: 0.2;
    }

    #style-yXWHo.style-yXWHo {
        height: 67px;
    }

    #tsuid_46.style-1tHDT {
        border: none;
        width: 120px;
        opacity: 0.2;
    }

    #style-oQDnA.style-oQDnA {
        height: 67px;
    }

    #style-8ooMt.style-8ooMt {
        top: 0px;
    }

    #style-99EVz.style-99EVz {
        background-color: #fff;
        color: #70757a;
    }

    #style-Afhhy.style-Afhhy {
        top: 0px;
    }

    #style-2ycaN.style-2ycaN {
        background-color: #fff;
        color: #70757a;
    }

    .scrollable-div {
        height: 800px;
        width: 100%;
        overflow: auto;

        padding: 10px;
    }
</style>
<div class="row">

    <div class="col-lg-5" >

        <div class="scrollable-div">


            <div class="form-inline my-2 my-lg-0 navbar-search position-relative">

                <input style="width:183px" class="form-control mr-5 rounded" type="text" name="search" placeholder="{{ trans('navbar.search_anything') }}" aria-label="Search">

                <button type="submit" class="btn-transparent d-flex align-items-center justify-content-center search-icon">
                    <i data-feather="search" width="20" height="20" class="mr-10"></i>
                </button>
                <div>

                    <select name="sort" class="form-control">
                        <option disabled selected>{{ trans('public.sort_by') }}</option>
                        <option value="">{{ trans('public.all') }}</option>
                        <option value="top_rate" @if (request()->get('sort', null) == 'top_rate') selected="selected" @endif>
                            {{ trans('site.top_rate') }}
                        </option>
                        <option value="top_sale" @if (request()->get('sort', null) == 'top_sale') selected="selected" @endif>Top Vus
                        </option>
                    </select>
                </div>
            </div>
            @if (!empty($videostitleAll))
            <h2 style="margin-top:30px">{{ $videostitleAll->titleAll }}</h2>
            @endif
            @if ($videos != '[]')
            <div style="margin-top:15px">

                <video id="mainVideoPlayer" controls></video>

                <div id="title" class="style-scope ytd-watch-metadata" style="margin-top:10px">
                    <ytd-badge-supported-renderer class="style-scope ytd-watch-metadata" disable-upgrade="" hidden="">
                    </ytd-badge-supported-renderer>
                    <h3 id="titleshoww"></h3>

                    <ytd-badge-supported-renderer class="style-scope ytd-watch-metadata" disable-upgrade="" hidden="">
                    </ytd-badge-supported-renderer>
                </div>

                <div id="top-row" class="style-scope ytd-watch-metadata">
                    <div id="owner" class="item style-scope ytd-watch-metadata">
                        <ytd-video-owner-renderer class="style-scope ytd-watch-metadata">
                            <a class="yt-simple-endpoint style-scope ytd-video-owner-renderer" href="">
                                <yt-img-shadow id="avatar" width="40" class="style-scope ytd-video-owner-renderer no-transition style-oRzbr">
                                    <img id="img" class="style-scope yt-img-shadow" width="40" src="{{ $videos[0]->teachers->avatar }}">
                                </yt-img-shadow>
                            </a>
                            <div id="upload-info" class="style-scope ytd-video-owner-renderer">
                                <ytd-channel-name id="channel-name" class="style-scope ytd-video-owner-renderer">
                                    <div id="container" class="style-scope ytd-channel-name">
                                        <div id="text-container" class="style-scope ytd-channel-name">
                                            <yt-formatted-string id="text" class="style-scope ytd-channel-name complex-string">
                                                <h4 id="nameteacher" class="yt-simple-endpoint style-scope yt-formatted-string" href="" dir="auto">

                                                </h4>
                                            </yt-formatted-string>
                                        </div>

                                    </div>
                                    <ytd-badge-supported-renderer class="style-scope ytd-channel-name">
                                    </ytd-badge-supported-renderer>
                                </ytd-channel-name>
                                <yt-formatted-string id="owner-sub-count" class="style-scope ytd-video-owner-renderer">
                                </yt-formatted-string>
                            </div>
                            <div class="style-scope ytd-video-owner-renderer">
                            </div>
                            <div class="style-scope ytd-video-owner-renderer">
                            </div>
                            <div class="style-scope ytd-video-owner-renderer">
                            </div>
                        </ytd-video-owner-renderer>
                        <div id="subscribe-button" style="margin-left:20px" class="style-scope ytd-watch-metadata">
                            <ytd-subscribe-button-renderer class="style-scope ytd-watch-metadata">
                                <yt-smartimation class="style-scope ytd-subscribe-button-renderer">
                                    <yt-button-shape class="style-scope ytd-subscribe-button-renderer">
                                        <button class="yt-spec-button-shape-next yt-spec-button-shape-next--filled yt-spec-button-shape-next--mono yt-spec-button-shape-next--size-m  style-OodnQ" id="style-OodnQ">
                                            <div class="yt-spec-button-shape-next--button-text-content">
                                                <span class="yt-core-attributed-string yt-core-attributed-string--white-space-no-wrap">
                                                    S'abonner
                                                </span>
                                            </div>
                                            <yt-touch-feedback-shape id="style-jI9g2" class="style-jI9g2">
                                                <div class="yt-spec-touch-feedback-shape yt-spec-touch-feedback-shape--touch-response-inverse">
                                                    <div class="yt-spec-touch-feedback-shape__stroke style-EzHpd" id="style-EzHpd">
                                                    </div>
                                                    <div class="yt-spec-touch-feedback-shape__fill style-yhVGc" id="style-yhVGc">
                                                    </div>
                                                </div>
                                            </yt-touch-feedback-shape>
                                        </button>
                                    </yt-button-shape>
                                    <div class="style-scope ytd-subscribe-button-renderer">
                                        <form action="/panel/add" method="POST">
                                            @csrf
                                            <input id="user_iddteacher" name="trtr" class="yt-simple-endpoint style-scope yt-formatted-string" hidden />


                                            <button type="submit" class="btn btn-subscribe">Ajouter</button>

                                        </form>


                                    </div>

                                </yt-smartimation>
                            </ytd-subscribe-button-renderer>
                        </div>
                    </div>

                </div>

            </div>
            @else
            
                        <div class="no-result-logo p-50 m-30">
                        <img src="/assets/default/img/no-results/files.png" />
                        </div>
                        <h2 class="section-title text-center">Look for the captivating icons within your book,</h2>       
                         <p class="mt-1 text-center">Click and dive into immersive video capsules</p>
                        
        
            @endif



            <div style="margin-top:10px" class="sI5x9c">


                @foreach ($videos as $video)
                <div class="row">
                    <div class="col-sm-5">
                        <a class="X5OiLe vGvPJe" href="#VIDEOOPENID">
                            <div class="WM9LLd" style="margin-top:10px">
                                <div>
                                    <video width="160" height="155" poster="{{ asset($video->thumbnail) }}" onclick="playInMainPlayer('{{ asset($video->video) }}','{{ $video->titre }}','{{ $video->teachers->full_name }}','{{ $video->user_id }}','{{ $video->teachers->avatar }}')">
                                        <source src="{{ $video->video }}" type="video/mp4">
                                        <source src="{{ $video->video }}" type="video/webm">
                                    </video>
                                    {{-- <iframe width="560" height="115" src="{{$video->video}}" ></iframe> --}}
                                </div>



                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a class="X5OiLe" href="">
                            <div class="WZIVy">
                                <div class="uOId3b">
                                    <div class="fc9yUc tNxQIb ynAwRc OSrXXb">
                                        <span class="cHaqb">
                                            {{ $video->titre }}
                                        </span>
                                    </div>
                                </div>
                                <br>
                                <div class="FzCfme">

                                    <a class="yt-simple-endpoint style-scope ytd-video-owner-renderer" href="">
                                        <yt-img-shadow id="avatar" width="40" class="style-scope ytd-video-owner-renderer no-transition style-oRzbr">
                                            <img id="img" class="style-scope yt-img-shadow" width="40" src=" {{ $video->teachers->avatar }}">
                                        </yt-img-shadow>
                                    </a>

                                    <h4 class="yt-simple-endpoint style-scope yt-formatted-string" href="" dir="auto">
                                        {{ $video->teachers->full_name }}
                                    </h4>

                                    <div>
                                        <div class="V8fWH">
                                            10 minutes et 24&nbsp;secondes
                                        </div>
                                    </div>
                                    <div class="hMJ0yc">
                                        <span>
                                            01 juin 2023
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
                @endforeach





            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <img src="/assets/default/img/arrow-left.png" id="scroll-left" style="position: absolute; left: 15px; cursor:pointer;    margin-top: 12px;" />

        <div id="navbar22" class="nav-scroll">
            <ul class="nav nav-pills scrollmenu">
                <div class="scrollmenu">
                    @foreach ($matiere as $math)
                    <?php
                    $manuels = DB::table('manuels')
                        ->where('material_id', '=', $math->id)
                        ->get();

                    ?>
                    @foreach ($manuels as $manuel)
                    <li class="nav-item ">
                        <a class="nav-link {{ $manuel->id == $id ? 'active' : '' }}" href="/panel/scolaire/{{ $manuel->id }}icon=1&page=6">{{ $manuel->name }}</a>
                    </li>
                    @endforeach
                    @endforeach
                </div>
                <!-- Add more categories as needed -->
            </ul>
        </div>
        <img src="/assets/default/img/arrow-right.png" id="scroll-right" style="position: absolute;right: 19px; margin-top: -41px; cursor:pointer!important;" />

        <div style="padding:10px">
            <object data="{{ asset($pdfPath) }}#toolbar=0&page={{ $page }}&zoom=79" type="application/pdf" width="100%" height="880px">
                <p>Unable to display PDF file. <a href="{{ $pdfPath }}">Download</a> instead.</p>
            </object>
        </div>
    </div>
    <div class="col-lg-1" style="
    padding-left: 0px;
    padding-right: 10px!important;
">

        <section>

            <div class="mt-20 p-20 rounded-sm shadow-lg border border-gray300 filters-container">
                <h4 class="category-filter-title font-20 font-weight text-dark-blue">My Teacher</h4>

                <div class="form-group mt-20">

                    <div class="user-search-card text-center d-flex flex-column align-items-center justify-content-center">
                        <div class="user-avatar" style="width:65px;height:57px!important;">
                            <img src="/store/870/avatar/617a4f7c09d61.png" class="img-cover rounded-circle" style="width:60px;height:60px!important;">
                        </div>
                        <a href="">

                            <span class="d-block font-14 text-gray mt-5">Jessica Wray</span>
                        </a>
                    </div>
                    <br>

                    <div class="user-search-card text-center d-flex flex-column align-items-center justify-content-center">
                        <div class="user-avatar" style="width:65px;height:57px!important;">
                            <img src="/store/1015/avatar/6417573dd820b.png" class="img-cover rounded-circle" style="width:60px;height:60px!important;">
                        </div>
                        <a href="">
                            <span class="d-block font-14 text-gray mt-5">Mohamed romdhane</span>
                        </a>
                    </div>

                    <br>
                    <div class="user-search-card text-center d-flex flex-column align-items-center justify-content-center">
                        <div class="user-avatar" style="width:65px;height:57px!important;">
                            <img src="/store/929/avatar/617a4f5d834c8.png" class="img-cover rounded-circle" style="width:60px;height:60px!important;">
                        </div>
                        <a href="">
                            <span class="d-block font-14 text-gray mt-5">Kate Willi</span>
                        </a>
                    </div>
                </div>

            </div>
            <div class="mt-20 p-20 rounded-sm shadow-lg border border-gray300 filters-container">
                <h4 class="category-filter-title font-20 font-weight text-dark-blue">Options</h4>

                <div class="form-group mt-20">
                    <br>
                    <img src="/assets/default/img/iconres.jpg" class="img-cover rounded-circle" style="width:60px;margin-left:10px;height:60px!important;">
                    <br> <br>
                    <img src="/assets/default/img/noteicontake.jpg" class="img-cover rounded-circle" style="width:60px;margin-left:10px;height:60px!important;">
                    <br> <br>
                    <img src="/assets/default/img/iconvoice.jpg" class="img-cover rounded-circle" style="width:60px;margin-left:10px;height:60px!important;">
                </div>
            </div>


        </section>
    </div>
</div>


@endsection

@push('scripts_bottom')
<script>
    window.addEventListener('DOMContentLoaded', (event) => {

        const navbar = document.getElementById('navbar22');
        const scrollRightButton = document.getElementById('scroll-right');
        const scrollLeftButton = document.getElementById('scroll-left');
        console.log('after');
        scrollRightButton.addEventListener('click', function() {
            console.log('bfor');
            navbar.scrollBy({
                left: 200,
                behavior: 'smooth'
            });
        });

        scrollLeftButton.addEventListener('click', function() {
            navbar.scrollBy({
                left: -200,
                behavior: 'smooth'
            });
        });
    });
</script>
<script>
    function hideMainPlayer() {
        var mainPlayer = document.getElementById('mainVideoPlayer');
        var title = document.getElementById('title');
        var toprow = document.getElementById('top-row');
        mainPlayer.style.display = 'none'; // Hide the main player
        title.style.display = 'none';
        toprow.style.display = 'none';
    }

    function showMainPlayer() {
        var mainPlayer = document.getElementById('mainVideoPlayer');
        var title = document.getElementById('title');
        var toprow = document.getElementById('top-row');
        mainPlayer.style.display = 'block'; // Show the main player
        title.style.display = 'block';
        toprow.style.display = 'block';
    }

    function playInMainPlayer(url, title, nameteac, user_idd, imgteac) {


        var mainPlayer = document.getElementById('mainVideoPlayer');
        var titleshoww = document.getElementById('titleshoww');
        var nameteacher = document.getElementById('nameteacher');
        var user_iddteacher = document.getElementById('user_iddteacher');
        //var user_iddteacher1 = document.getElementById('user_iddteacher1');

        var imgteacher = document.getElementById('img');

        // Update the source and load the video
        mainPlayer.src = url;

        mainPlayer.style.top = '0';
        mainPlayer.style.left = '0';
        mainPlayer.style.width = '100%';
        mainPlayer.style.height = '100%';
        imgteacher.src = imgteac;

        nameteacher.textContent = nameteac;
        user_iddteacher.value = user_idd;

        //  user_iddteacher1.value = user_idd;

        titleshoww.textContent = title;
        mainPlayer.load();
        showMainPlayer();
        // Play the video
        mainPlayer.play();
    }
    window.onload = function() {
        hideMainPlayer(); // Hide the player when the page initially loads
    };
</script>
@endpush