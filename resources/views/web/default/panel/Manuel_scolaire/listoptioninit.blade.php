@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
@endpush
<style>
</style>
@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=YouTube+Sans:wght@300..900&display=swap"); 
@import url("https://fonts.googleapis.com/css?family=Roboto:300italic,400italic,500italic,700italic"); 

body { 
/* CSS Variables that may have been missed get put on body */ 
    --center-abs-margin:  180px;  
    --center-width:  652px;  
    --rhs-margin:  76px;  
    --rhs-width:  372px;  
    --center-abs-margin:  230px; 
} 

.aEkOAd { 
    position: relative; 
    top: 0; 
    z-index: 2; 
    height: 30px;
} 

.uVMCKf { 
    overflow: visible; 
    box-shadow: none; 
    border: none; 
    margin-top: 0; 
    margin-bottom: 46px;
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
    font-family: arial, "Tajawal, sans-serif"; 
    clear: both; 
    margin-left: 0; 
    padding-top: 20px; 
    box-sizing: border-box; 
    position: relative; 
    min-height: 100vh;
} 

.main { 
    min-width: calc(var(--center-abs-margin) + var(--center-width) + var(--rhs-margin) + var(--rhs-width)); 
    width: 100%;
} 

body { 
    font-family:   arial, "Tajawal, sans-serif";
    font-size:  14px;
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

@media (min-width: 1675px){ 
  .srp { 
    --center-abs-margin: 230px;
  } 
}     

html { 
    font-family: arial, "Tajawal, sans-serif";
} 

.OSrXXb { 
    overflow: hidden; 
    text-overflow: ellipsis;
} 

.SenEzd { 
    padding-top: 8px; 
    padding: 0; 
    margin-top: 0;
} 

.oYWfcb { 
    display:  block; 
    cursor:  pointer; 
    font-weight:  400; 
    line-height:  1.43;
    white-space:  nowrap;
    font-size: 16px; 
} 

g-more-link.RB2q5e { 
    cursor: initial; 
    text-align: center;
} 

.oYWfcb.RB2q5e { 
    overflow: visible;
} 

a { 
    color: #1a0dab; 
    text-decoration: none; 
    -webkit-tap-highlight-color: rgba(0,0,0,.1);
} 

a:hover { 
    text-decoration: underline;
} 

a.pYouzb  { 
    align-items: center; 
    display: flex;
} 

html:not(.zAoYTe) [href]  { 
    outline: 0;
} 

a.CHn7Qb:hover { 
    text-decoration: none;
} 

g-more-link.RB2q5e a.pYouzb  { 
    color: #202124; 
    display: inline-block; 
    pointer-events: none;
} 

.rhHIGd { 
    background-color: #dadce0; 
    border: 0; 
    height: 1px; 
    left: 0; 
    margin-top: 18px; 
    position: absolute; 
    width: 100%;
} 

.wHYlTd { 
    font-family: arial, "Tajawal, sans-serif"; 
    font-size: 14px; 
    line-height: 22px;
} 

.S8ee5 { 
    display:  flex; 
    box-sizing:  border-box; 
    cursor:  pointer; 
    background-color:  #f1f3f4; 
    border:  1px solid rgba(255,255,255,0);
    font-size:  14px; 
    line-height:  20px; 
    pointer-events:  auto; 
    position:  relative; 
    width:  300px; 
    padding:  7px 11px; 
    flex-direction:  row-reverse; 
    align-items:  center; 
    justify-content:  center; 
    margin-left:  auto; 
    margin-right:  auto; 
    height:  36px; 
    border-radius:  18px;
    background: #f1f3f4; 
} 

.S8ee5.CwbYXd { 
    color: #202124; 
    line-height: 22px;
} 

.S8ee5:hover { 
    background-color:  #d8d7dc;
    background: #d8d7dc;
} 

.HbX59e { 
    margin-left: 0px;
} 

.p8VO6e { 
    color:  #70757a; 
    height:  20px; 
    margin-top:  -2px; 
    margin-bottom:  -2px;
    flex: none;
} 

.S8ee5 .p8VO6e  { 
    margin-top: 0px;
} 

.Z4Cazf { 
    margin-right:  8px; 
    white-space:  initial;
    width:  auto;
} 

.S8ee5 .Z4Cazf  { 
    display: inline-block; 
    max-width: 220px; 
    white-space: nowrap;
} 

.z1asCe { 
    display: inline-block; 
    fill: currentColor; 
    height: 24px; 
    line-height: 24px; 
    position: relative; 
    width: 24px;
} 

.S8ee5 .z1asCe  { 
    height: 20px; 
    width: 20px;
} 

.z1asCe svg  { 
    display: block; 
    height: 100%; 
    width: 100%;
} 



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
    --ytd-watch-flexy-min-player-width: calc( var(--ytd-watch-flexy-min-player-height) * (var(--ytd-watch-flexy-width-ratio) / var(--ytd-watch-flexy-height-ratio)) ); 
    --ytd-watch-flexy-max-player-width: calc( ( 100vh - ( var(--ytd-watch-flexy-masthead-height) + var(--ytd-margin-6x) + var(--ytd-watch-flexy-space-below-player) ) ) * (var(--ytd-watch-flexy-width-ratio) / var(--ytd-watch-flexy-height-ratio)) );
} 

ytd-page-manager > .ytd-page-manager { 
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
    margin-top: var(--ytd-masthead-height,var(--ytd-toolbar-height));
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
    background-color:               #f9f9f9!important; 
    -webkit-text-size-adjust:               none;
    --yt-spec-base-background:              #fff; 
    --yt-spec-raised-background:              #fff; 
    --yt-spec-menu-background:              #fff; 
    --yt-spec-inverted-background:              #0f0f0f; 
    --yt-spec-additive-background:              rgba(0, 0, 0, 0.05); 
    --yt-spec-outline:              rgba(0, 0, 0, 0.1); 
    --yt-spec-text-primary:              #030303; 
    --yt-spec-text-primary-inverse:              #fff; 
    --yt-spec-text-secondary:              #606060; 
    --yt-spec-text-disabled:              #909090; 
    --yt-spec-call-to-action:              #065fd4; 
    --yt-spec-icon-inactive:              #909090; 
    --yt-spec-icon-disabled:              #ccc; 
    --yt-spec-touch-response:              #000; 
    --yt-spec-touch-response-inverse:              #fff; 
    --yt-spec-brand-link-text:              #c00; 
    --yt-spec-themed-blue:              #065fd4; 
    --yt-spec-static-brand-white:              #fff; 
    --yt-spec-static-overlay-text-primary:              #fff; 
    --yt-spec-static-overlay-text-secondary:              rgba(255, 255, 255, 0.7); 
    --yt-spec-static-overlay-text-disabled:              rgba(255, 255, 255, 0.3); 
    --yt-spec-static-overlay-button-secondary:              rgba(255, 255, 255, 0.1); 
    --yt-spec-brand-background-solid:              #fff; 
    --yt-spec-general-background-a:              #f9f9f9; 
    --yt-spec-general-background-b:              #f1f1f1; 
    --yt-spec-10-percent-layer:              rgba(0, 0, 0, 0.1); 
    --yt-spec-badge-chip-background:              rgba(0, 0, 0, 0.05); 
    --yt-spec-mono-filled-hover:              #272727; 
    --yt-spec-mono-tonal-hover:              rgba(0, 0, 0, 0.1); 
    --yt-spec-white-2:             #f9f9f9; 
    --yt-spec-grey-1:             #ccc; 
    --yt-spec-grey-5:             #606060; 
    --yt-spec-dark-blue:             #065fd4; 
    --yt-spec-black-pure-alpha-15:             rgba(0, 0, 0, 0.15); 
    --yt-deprecated-luna-black:            hsl(0, 0%, 6.7%); 
    --yt-deprecated-opalescence-soft-grey:            hsl(0, 0%, 93.3%); 
    --yt-deprecated-luna-black-opacity-lighten-1:            hsla(0, 0%, 6.7%, 0.8); 
    --yt-deprecated-luna-black-opacity-lighten-2:            hsla(0, 0%, 6.7%, 0.6); 
    --yt-deprecated-luna-black-opacity-lighten-3:            hsla(0, 0%, 6.7%, 0.4); 
    --yt-deprecated-opalescence-soft-grey-opacity-lighten-3:            hsla( 0, 0%, 93.3%, 0.4 ); 
    --yt-deprecated-luna-black-opacity-lighten-4:           hsla(0, 0%, 6.7%, 0.2); 
    --yt-opalescence-dark-grey:           hsl(0, 0%, 20%); 
    --yt-live-chat-action-panel-background-color-transparent:           hsla( 0, 0%, 97%, 0.8 ); 
    --yt-live-chat-primary-text-color:           var(--yt-spec-text-primary); 
    --yt-live-chat-secondary-text-color:           var( --yt-deprecated-luna-black-opacity-lighten-2 ); 
    --yt-live-chat-disabled-icon-button-color:           var( --yt-deprecated-luna-black-opacity-lighten-4 ); 
    --yt-live-chat-poll-primary-text-color:           var( --yt-spec-static-overlay-text-primary ); 
    --yt-live-chat-poll-tertiary-text-color:           var( --yt-spec-static-overlay-text-disabled ); 
    --ytd-toolbar-height:         56px; 
    --ytd-margin-3x:         12px; 
    --ytd-margin-6x:         24px; 
    --yt-navbar-title-font-size:        1.8rem; 
    --ytd-tab-system-font-size:        var(--yt-tab-system-font-size, 1.4rem); 
    --ytd-tab-system-font-weight:        500; 
    --ytd-tab-system-letter-spacing:        var(--yt-tab-system-letter-spacing, 0.007px); 
    --ytd-tab-system-text-transform:        uppercase; 
    --ytd-scrollbar-width:     8px; 
    scrollbar-color:    var(--yt-spec-text-secondary) transparent;
} 

html[darker-dark-theme] { 
    background-color: #fff!important;
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

html[darker-dark-theme-deprecate],[darker-dark-theme-deprecate] { 
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
    flex:  1; 
    flex-basis:  0.000000001px;
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

ytd-watch-metadata[flex-menu-enabled] #actions.ytd-watch-metadata  { 
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

ytd-watch-metadata[flex-menu-enabled] #actions-inner.ytd-watch-metadata  { 
    width: 100%;
} 

.yt-simple-endpoint { 
    display: inline-block; 
    cursor: pointer; 
    text-decoration: none; 
    color: var(--yt-endpoint-color,var(--yt-spec-text-primary));
} 

.yt-simple-endpoint.ytd-video-owner-renderer { 
    display: inline-block; 
    cursor: pointer; 
    text-decoration: none; 
    color: var(--yt-endpoint-color,var(--yt-spec-text-primary));
} 

.yt-simple-endpoint:hover { 
    color: var(--yt-endpoint-hover-color,var(--yt-spec-text-primary)); 
    -webkit-text-decoration: var(--yt-endpoint-text-decoration,none); 
    text-decoration: var(--yt-endpoint-text-decoration,none);
} 

.yt-simple-endpoint.ytd-video-owner-renderer:hover { 
    color: var(--yt-endpoint-hover-color,var(--yt-spec-text-primary)); 
    -webkit-text-decoration: var(--yt-endpoint-text-decoration,none); 
    text-decoration: var(--yt-endpoint-text-decoration,none);
} 

#upload-info.ytd-video-owner-renderer { 
    flex: 1; 
    flex-basis: 0.000000001px; 
    display: flex; 
    flex-direction: column; 
    justify-content: center;
} 

ytd-video-owner-renderer[watch-metadata-refresh] #upload-info.ytd-video-owner-renderer  { 
    margin-right: 24px; 
    overflow: hidden;
} 

[hidden] { 
    display: none!important;
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
    color: var(--yt-endpoint-color,var(--yt-spec-text-primary)); 
    display: flex; 
    flex-direction: row; 
    font-family: "Roboto","Arial", "Tajawal, sans-serif"; 
    font-size: 1.6rem; 
    line-height: 2.2rem; 
    font-weight: 500;
} 

ytd-video-owner-renderer[watch-metadata-refresh] #channel-name.ytd-video-owner-renderer  { 
    max-width: 100%;
} 

#owner-sub-count.ytd-video-owner-renderer { 
    color: var(--yt-spec-text-secondary); 
    margin-right: 4px; 
    font-family: "Roboto","Arial", "Tajawal, sans-serif"; 
    
} 

ytd-video-owner-renderer[watch-metadata-refresh] #owner-sub-count.ytd-video-owner-renderer  { 
    font-family: "Roboto","Arial", "Tajawal, sans-serif"; 
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

ytd-watch-metadata[flex-menu-enabled] #actions.ytd-watch-metadata ytd-menu-renderer.ytd-watch-metadata  { 
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
    margin-left: var(--yt-img-margin-left,auto); 
    margin-right: var(--yt-img-margin-right,auto); 
    max-height: var(--yt-img-max-height,none); 
    max-width: var(--yt-img-max-width,100%); 
    border-radius: var(--yt-img-border-radius,none);
} 

#container.ytd-channel-name { 
    display: var(--ytd-channel-name-container-display,inline-block); 
    overflow: hidden; 
    max-width: 100%;
} 

ytd-badge-supported-renderer { 
    display: flex; 
    flex-direction: row; 
    align-items: center;
} 

ytd-badge-supported-renderer.ytd-channel-name { 
    display: var(--ytd-channel-name-badges-display,flex); 
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

#top-level-buttons-computed.ytd-menu-renderer:not(:empty) + #flexible-item-buttons.ytd-menu-renderer + #button.ytd-menu-renderer  { 
    margin-left: 8px;
} 

yt-button-shape.ytd-menu-renderer { 
    flex: none;
} 

ytd-menu-renderer[has-items] yt-button-shape.ytd-menu-renderer  { 
    margin-left: 8px;
} 

#text-container.ytd-channel-name { 
    display: var(--ytd-channel-name-text-container-display,block);
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
    font-family: "Roboto","Arial", "Tajawal, sans-serif"; 
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
    color:  var(--yt-spec-text-primary-inverse); 
    background-color:  var(--yt-spec-text-primary);
} 

.yt-spec-button-shape-next--mono.yt-spec-button-shape-next--filled:hover { 
    background-color:  var(--yt-spec-mono-filled-hover); 
    border-color:  transparent;
} 

ytd-segmented-like-dislike-button-renderer { 
    display: flex;
} 

ytd-button-renderer { 
    display: inline-block;
} 

ytd-menu-renderer:not([condensed]) .ytd-menu-renderer[button-renderer] + .ytd-menu-renderer[button-renderer]  { 
    margin-left: 8px;
} 

ytd-download-button-renderer[is-hidden] { 
    display: none;
} 

#flexible-item-buttons.ytd-menu-renderer:not(:empty) > .ytd-menu-renderer[button-renderer]  { 
    margin-left: 8px;
} 

ytd-menu-renderer:not([condensed]) .ytd-menu-renderer[button-renderer] + .ytd-menu-renderer[button-renderer] ,#flexible-item-buttons.ytd-menu-renderer:not(:empty) > .ytd-menu-renderer[button-renderer]  { 
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
    color:  var(--yt-spec-text-primary); 
    background-color:  var(--yt-spec-badge-chip-background);
} 

.yt-spec-button-shape-next--mono.yt-spec-button-shape-next--tonal:hover { 
    background-color:  var(--yt-spec-mono-tonal-hover); 
    border-color:  transparent;
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
    -webkit-line-clamp: var(--ytd-channel-name-text-line-clamp,inherit); 
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

tp-yt-paper-tooltip .tp-yt-paper-tooltip[style-target="tooltip"]  { 
    margin: 8px; 
    text-transform: none; 
    word-break: normal; 
    font-family: "Roboto","Arial", "Tajawal, sans-serif"; 
    font-size: 1.2rem; 
    line-height: 1.8rem; 
    font-weight: 400;
} 

body[rounded-container] tp-yt-paper-tooltip .tp-yt-paper-tooltip[style-target="tooltip"]  { 
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
    fill: var(--iron-icon-fill-color,currentcolor); 
    stroke: var(--iron-icon-stroke-color,none); 
    width: var(--iron-icon-width,24px); 
    height: var(--iron-icon-height,24px); 
    -webkit-animation: var(--iron-icon-animation); 
    animation: var(--iron-icon-animation); 
    margin-top: var(--iron-icon-margin-top); 
    margin-right: var(--iron-icon-margin-right); 
    margin-bottom: var(--iron-icon-margin-bottom); 
    margin-left: var(--iron-icon-margin-left); 
    padding: var(--iron-icon-padding);
} 

button.yt-icon-button > yt-icon  { 
    width: var(--yt-icon-button-icon-width,100%); 
    height: var(--yt-icon-button-icon-height,100%);
} 

#button.ytd-menu-renderer yt-icon.ytd-menu-renderer  { 
    color: var(--ytd-menu-renderer-button-color,var(--yt-spec-icon-inactive));
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

yt-interaction.circular .stroke.yt-interaction  { 
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

yt-interaction.circular .fill.yt-interaction  { 
    border-radius: 50%;
} 

.yt-spec-button-shape-next__icon { 
    line-height: 0; 
    fill: currentColor;
} 

.yt-spec-button-shape-next--size-m .yt-spec-button-shape-next__icon  { 
    width: 24px; 
    height: 24px;
} 

a.yt-formatted-string { 
    color: var(--yt-spec-call-to-action);
} 

a.yt-simple-endpoint.yt-formatted-string { 
    color: var(--yt-endpoint-color,var(--yt-spec-call-to-action)); 
    display: var(--yt-endpoint-display,inline-block); 
    -webkit-text-decoration: var(--yt-endpoint-text-regular-decoration,none); 
    text-decoration: var(--yt-endpoint-text-regular-decoration,none); 
    word-wrap: var(--yt-endpoint-word-wrap,none); 
    word-break: var(--yt-endpoint-word-break,none);
} 

yt-formatted-string[ellipsis-truncate-styling] a.yt-formatted-string  { 
    display: block; 
    margin-right: -0.1em; 
    padding-right: 0.1em; 
    white-space: pre;
} 

yt-formatted-string[ellipsis-truncate-styling] a.yt-formatted-string:last-child  { 
    overflow: hidden; 
    text-overflow: ellipsis;
} 

yt-formatted-string[has-link-only_]:not([force-default-style]) a.yt-simple-endpoint.yt-formatted-string  { 
    color: var(--yt-endpoint-color,var(--yt-spec-text-primary));
} 

a.yt-simple-endpoint.yt-formatted-string:hover { 
    color: var(--yt-endpoint-hover-color,var(--yt-spec-call-to-action)); 
    -webkit-text-decoration: var(--yt-endpoint-text-decoration,none); 
    text-decoration: var(--yt-endpoint-text-decoration,none);
} 

yt-formatted-string[has-link-only_]:not([force-default-style]) a.yt-simple-endpoint.yt-formatted-string:hover  { 
    color: var(--yt-endpoint-hover-color,var(--yt-spec-text-primary));
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
    vertical-align:  middle; 
    font-size:  var(--ytd-tab-system-font-size); 
    font-weight:  var(--ytd-tab-system-font-weight); 
    letter-spacing:  var(--ytd-tab-system-letter-spacing); 
    text-transform:  var(--ytd-tab-system-text-transform);
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

.yt-spec-touch-feedback-shape--touch-response-inverse .yt-spec-touch-feedback-shape__stroke  { 
    border:  1px solid var(--yt-spec-touch-response-inverse);
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

.yt-spec-touch-feedback-shape--touch-response-inverse .yt-spec-touch-feedback-shape__fill  { 
    background-color:  var(--yt-spec-touch-response-inverse);
} 

.yt-spec-button-shape-next--size-m.yt-spec-button-shape-next--icon-leading-trailing .yt-spec-button-shape-next__icon  { 
    margin-right: 6px; 
    margin-left: -6px;
} 

.yt-spec-button-shape-next__secondary-icon { 
    line-height: 0; 
    fill: currentColor;
} 

.yt-spec-button-shape-next--size-m.yt-spec-button-shape-next--icon-leading-trailing .yt-spec-button-shape-next__secondary-icon  { 
    margin-left: 6px; 
    margin-right: -6px;
} 

.yt-spec-button-shape-next--size-m.yt-spec-button-shape-next--icon-leading .yt-spec-button-shape-next__icon  { 
    margin-right: 6px; 
    margin-left: -6px;
} 

.yt-spec-touch-feedback-shape--touch-response .yt-spec-touch-feedback-shape__stroke  { 
    border:  1px solid var(--yt-spec-touch-response);
} 

.yt-spec-touch-feedback-shape--touch-response .yt-spec-touch-feedback-shape__fill  { 
    background-color:  var(--yt-spec-touch-response);
} 

.yt-spec-button-shape-next--size-m.yt-spec-button-shape-next--segmented-start { 
    border-radius: 18px 0 0 18px; 
    position: relative;
} 

.yt-spec-button-shape-next--size-m.yt-spec-button-shape-next--segmented-start:after { 
    content:  ""; 
    background:  var(--yt-spec-10-percent-layer); 
    position:  absolute; 
    right:  0; 
    top:  6px; 
    height:  24px; 
    width:  1px;
} 

.yt-spec-button-shape-next--size-m.yt-spec-button-shape-next--segmented-end { 
    border-radius: 0 18px 18px 0;
} 

.yt-spec-button-shape-next--size-m.yt-spec-button-shape-next--icon-button.yt-spec-button-shape-next--segmented-end { 
    padding: 0 16px; 
    width: 52px;
} 

.yt-spec-button-shape-next--size-m.yt-spec-button-shape-next--icon-button.yt-spec-button-shape-next--segmented-end .yt-spec-button-shape-next__icon  { 
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

yt-animated-icon[animated-icon-type="LIKE"] ytd-lottie-player.yt-animated-icon  { 
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
#style-OodnQ.style-OodnQ {  
}  
#style-jI9g2.style-jI9g2 {  
   border-radius: inherit;  
}  
#style-EzHpd.style-EzHpd {  
}  
#style-yhVGc.style-yhVGc {  
}  
#style-FDeto.style-FDeto {  
}  
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
#style-HiW8I.style-HiW8I {  
}  
#style-oIF9b.style-oIF9b {  
}  
#style-kTvf4.style-kTvf4 {  
}  
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
#style-WXZYF.style-WXZYF {  
}  
#style-hES7I.style-hES7I {  
}  
#style-QQgZh.style-QQgZh {  
   inset: 83.5px auto auto 599.664px;  
}  
#style-milm1.style-milm1 {  
}  
#style-hD9dO.style-hD9dO {  
   width: 24px;  
    height: 24px;  
}  
#style-ZPpbK.style-ZPpbK {  
   border-radius: inherit;  
}  
#style-s53wU.style-s53wU {  
}  
#style-gsk9r.style-gsk9r {  
}  
#style-h5tZF.style-h5tZF {  
   inset: 83.5px auto auto 644.969px;  
}  
#style-klbg6.style-klbg6 {  
}  
#style-2Levx.style-2Levx {  
   width: 24px;  
    height: 24px;  
}  
#style-84rEp.style-84rEp {  
   border-radius: inherit;  
}  
#style-yO9s5.style-yO9s5 {  
}  
#style-MKkFH.style-MKkFH {  
}  
#style-roBep.style-roBep {  
}  
#style-iMyph.style-iMyph {  
   width: 24px;  
    height: 24px;  
}  
#style-UADgx.style-UADgx {  
   border-radius: inherit;  
}  
#style-NRPos.style-NRPos {  
}  
#style-Z9hEz.style-Z9hEz {  
}  
#style-GKKaE.style-GKKaE {  
}  
#style-Bo2S6.style-Bo2S6 {  
   width: 24px;  
    height: 24px;  
}  
#style-TiGsh.style-TiGsh {  
   border-radius: inherit;  
}  
#style-HAs52.style-HAs52 {  
}  
#style-G4F1h.style-G4F1h {  
}  
#style-8l8Rz.style-8l8Rz {  
}  
#style-QW6JW.style-QW6JW {  
   width: 24px;  
    height: 24px;  
}  
#style-b45qW.style-b45qW {  
   border-radius: inherit;  
}  
#style-2Ukhx.style-2Ukhx {  
}  
#style-yLeOT.style-yLeOT {  
}  

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
    background-color: rgba(0,0,0,0.03); 
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
    transform: translate(-50%,-50%);
} 

.BQavlc { 
    background-color: rgba(0,0,0,.54); 
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

.X5OiLe:hover .uOId3b  { 
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
    font-family: arial, "Tajawal, sans-serif"; 
    font-size: 16px; 
    font-weight: 400; 
    line-height: 24px;
} 

.pcJO7e { 
    display:  block; 
    max-width:  100%; 
    overflow:  hidden; 
    text-overflow:  ellipsis; 
    white-space:  nowrap;
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

.z1asCe svg  { 
    display: block; 
    height: 100%; 
    width: 100%;
} 

.BQavlc.w2wy2 svg  { 
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

.pcJO7e cite  { 
    font-size: 14px; 
    line-height: 22px;
} 

.V8fWH { 
    border: 0; 
    clip: rect(0 0 0 0); 
    -webkit-clip-path: polygon(0 0,0 0,0 0); 
    clip-path: polygon(0 0,0 0,0 0); 
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
    background-color: rgba(0,0,0,.54); 
    border-radius: 8px; 
    color: #fff; 
    font-family: arial, "Tajawal, sans-serif"-medium, "Tajawal, sans-serif"; 
    font-size: 12px; 
    line-height: 14px; 
    padding: 1px 8px; 
    text-align: center;
} 


/* These were inline style tags. Uses id+class to override almost everything */
#style-o1LZl.style-o1LZl {  
   border-radius:8px;  
}  
#style-J4Lnt.style-J4Lnt {  
   height:35px;  
   line-height:35px;  
   width:35px;  
}  
#style-BrwYe.style-BrwYe {  
   height:14px;  
   line-height:14px;  
   width:14px;  
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
    font-family: arial, "Tajawal, sans-serif"; 
    clear: both; 
    margin-left: 0; 
    padding-top: 20px; 
    box-sizing: border-box; 
    position: relative; 
    min-height: 100vh;
} 

.main { 
    min-width: calc(var(--center-abs-margin) + var(--center-width) + var(--rhs-margin) + var(--rhs-width)); 
    width: 100%;
} 

body { 
    font-family:   arial, "Tajawal, sans-serif";
    font-size:  14px;
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

@media (min-width: 1675px){ 
  .srp { 
    --center-abs-margin: 230px;
  } 
}     

html { 
    font-family: arial, "Tajawal, sans-serif";
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
    transform: translate3d(0,0,0);
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

g-left-button  { 
    margin-top: 30px;
} 

.wgbRNb.tHT0l { 
    -webkit-transition: opacity 0.5s,visibility 0.5s; 
    transition: opacity 0.5s,visibility 0.5s;
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

g-right-button  { 
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

.bCwlI.T9Wh5 g-fab  { 
    cursor: pointer; 
    height: 36px; 
    width: 36px;
} 

.VdehBf.T9Wh5 g-fab  { 
    cursor: pointer; 
    height: 36px; 
    width: 36px;
} 

li { 
    margin: 0; 
    padding: 0;
} 

ol li  { 
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

.CNf3nf .PUDfGe  { 
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
    -webkit-tap-highlight-color: rgba(0,0,0,.1);
} 

.q9yZOe { 
    width: 100%; 
    height: 100%; 
    display: inline-flex; 
    flex-direction: column; 
    border-right: 1px solid #dadce0;
} 

html:not(.zAoYTe) [href]  { 
    outline: 0;
} 

a:hover { 
    text-decoration: underline;
} 

.z1asCe svg  { 
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

.oLJ4Uc img  { 
    width: 100%; 
    display: block;
} 

.tVRLD { 
    width: 100%; 
    display: flex; 
    align-items: center; 
    justify-content: flex-start; 
    font-family: arial, "Tajawal, sans-serif"; 
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
    font-family: arial, "Tajawal, sans-serif"; 
    font-size: 14px; 
    margin-top: 0; 
    word-break: break-word; 
    color: #3c4043;
} 


/* These were inline style tags. Uses id+class to override almost everything */
#_qXdVZJqbOJv-7_UPmvOKsAk_32.style-4V3fk {  
   padding-top:16px;  
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
   height:67px;  
}  
#style-N3U2Y.style-N3U2Y {  
   border: none;  
    width: 120px;  
    padding-right: 12px;  
    opacity: 1;  
}  
#style-VodIa.style-VodIa {  
   height:67px;  
}  
#style-oQd4Z.style-oQd4Z {  
   border: none;  
    width: 120px;  
    padding-right: 12px;  
    opacity: 1;  
}  
#style-WCyVT.style-WCyVT {  
   height:67px;  
}  
#style-d2o4t.style-d2o4t {  
   border: none;  
    width: 120px;  
    padding-right: 12px;  
    opacity: 1;  
}  
#style-Vc5bZ.style-Vc5bZ {  
   height:67px;  
}  
#style-VIP4d.style-VIP4d {  
   border: none;  
    width: 120px;  
    padding-right: 12px;  
    opacity: 1;  
}  
#style-Vz5nw.style-Vz5nw {  
   height:67px;  
}  

#tsuid_42.style-vgVaC {  
   border: none;  
    width: 84px;  
    padding-right: 12px;  
    opacity: 0.2;  
}  
#style-mUegq.style-mUegq {  
   height:67px;  
}  
#tsuid_44.style-BmsIp {  
   border: none;  
    width: 120px;  
    padding-right: 12px;  
    opacity: 0.2;  
}  
#style-yXWHo.style-yXWHo {  
   height:67px;  
}  
#tsuid_46.style-1tHDT {  
   border: none;  
    width: 120px;  
    opacity: 0.2;  
}  
#style-oQDnA.style-oQDnA {  
   height:67px;  
}  
#style-8ooMt.style-8ooMt {  
   top: 0px;  
}  
#style-99EVz.style-99EVz {  
   background-color:#fff;  
   color:#70757a;  
}  
#style-Afhhy.style-Afhhy {  
   top:0px;  
}  
#style-2ycaN.style-2ycaN {  
   background-color:#fff;  
   color:#70757a;  
}  

</style>
{{-- <div class="container" style="
    margin-left: 0px;
    margin-right: 0px!important;
"> --}}
    <!-- <div class="row">

    <div class="col-lg-5"> -->

              

                   <!-- <div class="form-inline my-2 my-lg-0 navbar-search position-relative">
                       <div style="margin-left:325px;margin-right:10px">
                        <select name="sort" class="form-control">
                            <option disabled selected>{{ trans('public.sort_by') }}</option>
                            <option value="">{{ trans('public.all') }}</option>
                            <option value="top_rate" @if(request()->get('sort',null) == 'top_rate') selected="selected" @endif>{{ trans('site.top_rate') }}</option>
                            <option value="top_sale" @if(request()->get('sort',null) == 'top_sale') selected="selected" @endif>Top Vus</option>
                        </select>
                        </div>
                        <input class="form-control mr-5 rounded" type="text" name="search" placeholder="{{ trans('navbar.search_anything') }}" aria-label="Search">

                       <button type="submit" class="btn-transparent d-flex align-items-center justify-content-center search-icon">
                        <i data-feather="search" width="20" height="20" class="mr-10"></i>
                       </button>
                   </div> -->
                
   <!-- <div style="margin-top:15px">



</div> -->
  <!-- <g-scrolling-carousel class="Lzivkf style-4V3fk" id="_qXdVZJqbOJv-7_UPmvOKsAk_32">
    <div  id="style-ebBB1">
      <div class="DAVP1">
        <ol class="bc7Xde">
          <li>
            <a class="q9yZOe style-JxznW" href="https://www.youtube.com/watch?v=gJWNA3Fduek&amp;t=0" id="style-JxznW">
              <div>
                <div class="k8E1vb oLJ4Uc style-ST9Kp" id="style-ST9Kp">
                  <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIAEMAeAMBIgACEQEDEQH/xAAbAAADAQEBAQEAAAAAAAAAAAAAAQMCBAYFB//EAC0QAAMAAgEEAQIEBgMAAAAAAAABAgMRBAUSITFBcYETYZHwBkJRosHxFCMy/8QAGAEBAQEBAQAAAAAAAAAAAAAAAAEEAwL/xAAeEQEBAQACAQUAAAAAAAAAAAAAAQIRMQMEEiFBkf/aAAwDAQACEQMRAD8A/VZRSZHMlEihKTaQ0jSRQkh9ux6GBjtDtNhogn2h2lNC0BNyZclmtmWgIOTDk6GjNIg5qkRWpGBSUbSFJRFAkAwAAD5Pl9a6hfE4lvjy6ya8a+AH1bqscLHU4tXn/p8T9Tl/hvm83lulyqdzkv8A67aS8Lfd9vS+rPiZORxMmXjPLdPj5Xuqjy9fO/ne/fz7+T1/Sox1lyZsfasMSsePt9Je3r+39DrZM467Z/Hq71dX8dVaWSlPpaEfK6N1zi9UrNjxvszRVPsp+anfil+/B9VHJq1m5vFAAwDyWjFIoZaIJUhGqABybRKWUTKNgIAFb8PRw5+Osu9o7mjLkDyHVOlThv8AHxS9fzSvn8/qeprjf8boccSNzVx2trw9vzX+SfLWGHj/AB6UxWSZbfr2Q/ibqV8bg1m4nbktNY5a8pN+39tIt1bODPjl38d149cDJ0/rOPLGXV49ue1+Ue86byK5XDx5rlTT3vX5PWzx/ReBn5eR5szrTe3Ve6Pa8XGsOCMcrSleDjma911emv1O5eM92fagDA6MhCYzLYGKAVMAJTRVM5popNAXTNbIqjaYFHSSfv7EK5EVCcZJnx3PvXx9P0KbJ/gYXveNeUl9l/pFEOTEZ24yXDlP1r4C+NifGjjqsepekkvG/odSw4l6n960aWLFvalbb7vuRXPixLBPZLlNfPY9L2XnNC/93PlvWvhL+v6Mo8cU9tbfow8GP053415b/fywNxSqVUvafyATKiVMrSXpA2EJsxTCmTqgFbAnT/MAJIomIANpmkxgBoaYAA0x7YABpM0hAFaM16AAJWRpgAROhAAH/9k=" class="IOZdEc mNbAre">
                </div>
                <div class="fYFvJb">
                  <div class="tVRLD">
                    À partir de&nbsp;
                    <span>
                      00:00
                    </span>
                  </div>
                  <div class="paD5uf">
                    Intro
                  </div>
                </div>
              </div>
            </a>
          </li>
          <li>
            <a class="q9yZOe style-N3U2Y" href="https://www.youtube.com/watch?v=gJWNA3Fduek&amp;t=5" id="style-N3U2Y">
              <div>
                <div class="k8E1vb oLJ4Uc style-VodIa" id="style-VodIa">
                  <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIAEMAeAMBIgACEQEDEQH/xAAcAAABBQEBAQAAAAAAAAAAAAAGAAMEBQcCAQj/xAA4EAACAQMDAwIDBgQFBQAAAAABAgMABBEFEiEGEzFBUSJhgQcUMkJxkSOhscEVJILR8DNDUlPh/8QAGQEAAwEBAQAAAAAAAAAAAAAAAAMEAQUC/8QAKhEAAgECBAUCBwAAAAAAAAAAAAECAxEEEiExEyJRYfBBwQUUFSMyotH/2gAMAwEAAhEDEQA/AMo0LTE1GaRZXZVjUH4fJzRk32dEW8U9vJJPHJEJcq6rtUj2P1FU/wBn1mL7WUsy+wXDxxlvYFq2GztrO1ggt3n1BMHtSKhidUUDcCCyAkfEMjH74GZZubqNX0O9h4YeOEhJxTm77p7XsYxrOhppobDP3I5DG6OQcEEg+PmKhQx5HNG/X9jFDMjWTXMyXeJ1E6juFi7gjC8HJHGPeq1tBt1dILe9kkuZIp5I17A7bdlpAw37vURMQduPA+dMoOTjzbknxWFGNZOirJpP+lIkYAxinBCDV1c9N31s4jaS3Y4ySpcbVxKckMoIH8GT09B7inpOmrmwSWTUpNscbiPbApZzIW27cPt+fxcg+hPo45hRdlceKaaJc+KJU6Yu5L0W0E8JZy2wSLIrYEnbBYBTty3zpm00IyXlpFeTdmO7ljihkjXeWZ1VsgErkKGG454JA55wADskWRnFMGL5USwdP3N7aQ3dmwNtPjtd5WVyC/byQoZfx5GAxbAzikOmpYr+1tr26toRcTJGg3MGkVu2SUyuMgSLw2CTkAHFAAxs2musLnkUQxdLX1wpltZbWWDHwyqX2ud0i4/BwcxNycL455pu56f+4W0l1qV0Pu6iPabRO4XL78Y3bARhGOQSPAB9gAdmiABPkVDeMZ4oqHTF5NI0VvcWzkRmfbIXjcQbiolYFeBxkrksARxXN30fefc4ryyngnt3thN3PjAdtrMyr8PGFA/HtyWA80ACEq4GKVeynIr2gC76Um1C2v8Au6VCZJkw/BA2kHIOTx5o8HUnVBYO+j2JcEHcVjzkUK9A5Fxe4/8AWv8AU1uOm9E2kk4uZLgz2Mke6NASGyfGSPIqyGFw3CVWq3d9OxPL4ljoVOBQStHql6+xjuuahrU80F3ewCB4mXtMm0hCpJAGOPOTzUC31K+t7NLWG5eOKMfAEAUgbt2Nw5xu5xnFE3XaQRRzx2hPYS5CoSc5AyM5oSkguIIUkntp4o3/AAPJGyhvXgkc0rEYeFCeWGzV9e57o4yrjI56trrTTbQlXGq31xHJvuWxLH2pFVQoKbi2MAAY3En6n3roazqLyl3uixKkMGRSrZOTuXGGJIByQTkA1XIRgjIp+3heZnEa7yiM7BfQAZJ/lSBpPGtaos/f++SGU+WYBvz788jzu5z5BriTVLkix2N2zYj+AVJJVixctz6ljn24FQSyj83inJIJV+8Bo2BtxmUH8g3BefqwH1oAk2uq3lrAkVtcNGifgAA45zjOPGedvjPpXS6zqedyXjqcqQVVRt2hQMccDCIMDAO0ZqrDgkjIrtCMjnigCVbX1/EqwRXTJHjaBgHbyxyMjg5d+Rz8R96vbiw6og7DTu/+YwqIVjcE8P8AEnIDchssN3rQ6jYI43YNWk/UmrXn3eKSdnNucxYABBAABJA5OABk5pFXiX5Pb3Ongfk8v37Xv65trabdx2Oz6n7avHcXeA5IfblidxOC3lhuYnacjJPFczaX1PdQlO9MY2QIAsK4C4K4XH4eCR8OOOPFKDWdWjmga5luDaiVTN25Dv2fnK58naGqvuur72C5mFldTPAHPbdm2llB4OPTj0pa4/li1/S16L9wY1azawuDBIwZsZPGMc4/tSrnV75r647zqFYjBwc55z/elVMM2VZtzjYnhcaXB/G+njL/AKLvrWxurn73OkIeMbWc4GQfetP0/qq+v7BdP0eVJIgNuLKIs37jOP5UE9C9c9M6DaxRar0hbzzoPiv49skjH3xJ4P6MB8hW0abrdp1v0/cw9OXeoaU5UAXBsyhj5/KSNp8YO05Hyq6li8kFBxTt1OXWwSqVHNSab6GadZabdaJp9hc6jbx7XuUYW7uNzBSSQw9iB8/P0qFJ1LYSyWkMe4RvJi7muF/7ZQK/CgncQGP5uXbk7jTfWX2ea3oMcupXuq2l/GBlppbgpM/+lz8X6BiflQSHpNevKtPPIdh6EaEMkdg1j6ugWNVFo6BJfgCAY2LIrISCcblRAn4fQfEPFODqe1mkKpBelXjaFrdZPhuCwUb2ySd3BAzu4xzwchYOQKdtrk208cqgEowbB9cUqNrq46V7OwYatqtzdiXtadeFxCVglkHKSkygseWOAkvjPmNPSnW6mto9Qb71bXNvHM4JtpMdlB957vdIGTuxxwDyPXwH+l+ptV6g1q306C3h3MCSwI3KvuAfOCRn5ZPoaF+s11GHqCeHV4UhvI1USLG25TnkEH2OafUhRUeSV352J6U67lzxsvO5cTa/b2jWcCXl3frF2jPc7iGl2NcMAckE4MsZ8/kxngGmdV1yC9sLl0BE8rLDGCTvWLZH3Cf1eIEck4kfPzEUepCn4csDtqcpPO7hiKI+k7NZr+Pu424y5Pz8fyzQsxHcNH32fy2zNeSXEQkSJQ2wjOeODj96XUbyjqCTmaFqeh2F7pO5YYjJHtkjdccY/tjI+tfP/U+n/wCF61d2YUhFfMeR+U8j+uPpW9wxx/4OhniAkiV5Fx4AJJ/asU68uo7rU4ZRjuCAbiPONxIz/wA9aVRfM0OxMdLgnJzSpP5zSqkjLzoW5uLfqexazC95iyDIB8qfGfB+fmtaF71HCxkSW9DDn47qVl/YvisP0O7ex1iyuY2CtFOrZPgc81t+nSat1D3bOxltkJjJaZh8KA+DxmosTmU1YqoZcruZHeyX13ctf38dy0txmQTSxsN4POQSPHPpxSNvcxx75LadEAB3NEwGCCRzj1AJHuATWqz9BdTaXpytb6xpt2tsibbeSBl3hBgKG5xkcegOT4yTWcDqzWlRoZJweNjh4gDkec/OrE09iZoZWzvEQsbS5ABAJMLDBIzjx5wQfqK4ubO7h2d63lUyKGQFfIOcH+R/Y1JHUuoSSrNK8Usy7h3HiBbDDBGfbGP2FSIerNYjZSLlSVJIOweuc+K0wrbGe/sbuC/09p4Z4WDxTRr4Pjj0Pt884qTqM2r6xd3Go363d1cMf40xhPGFGM4GF+HHtxTkfUOowwhInjQAADag4AG0Y/0nH/3mkeo9RMveaSN5A28M8YOG+LkfRiP0oAr0gnZ9gglL5A2hCTnOMY98kD605LFcW6t3oZkC+Q0ZFWC9Vascg3CgZzjYMev++OaYbq/UbVlWLs7QgXZ2wAAM4H7nPz+poAoJppHJySvyHGKMvsyBke7WNv8AMIyPtJ/EnII/TP8AWgcEnySSfJPrU3Sby9sL5LvTWkW4h5DIu7A9cj2rJaqx6hLLK5ufW10YuiL6RW+7GNFI2t+I7gAp9wfGKwi4uPvDs8xzM3Jf3Pzq66l6t1jXYYrTUSkMMR39iJCgZv8AyIJJP9KHCC0qgeteacMq1GVqim9Dhn9MUq8dgQa8r2JGasNL1XUNHkNxpV7cWkpGC0MhXcPY48/WlSoAtpuveq7xOxPrt4Y24IR9hI/VcGqtSQjNnn3NKlWJJAeoeTToPilSrQHHJ2jmmwTSpUAeE80zcAYz60qVAEUkjcR7VrOlWtva6M6QQogUuBxk/wDTU+ffLHn/AGFKlQB3rFja3HT38aBH2wgqSOQRApyD759f19zWSoT3l/evaVaBHbxSpUqwD//Z" class="IOZdEc mNbAre">
                </div>
                <div class="fYFvJb">
                  <div class="tVRLD">
                    À partir de&nbsp;
                    <span>
                      00:05
                    </span>
                  </div>
                  <div class="paD5uf">
                    Welcome
                  </div>
                </div>
              </div>
            </a>
          </li>
          <li>
            <a class="q9yZOe style-oQd4Z" href="https://www.youtube.com/watch?v=gJWNA3Fduek&amp;t=25" id="style-oQd4Z">
              <div>
                <div class="k8E1vb oLJ4Uc style-WCyVT" id="style-WCyVT">
                  <img src="data:image/jpeg;base64,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" class="IOZdEc mNbAre">
                </div>
                <div class="fYFvJb">
                  <div class="tVRLD">
                    À partir de&nbsp;
                    <span>
                      00:25
                    </span>
                  </div>
                  <div class="paD5uf">
                    3 Types of HTML Lists
                  </div>
                </div>
              </div>
            </a>
          </li>
          <li>
            <a class="q9yZOe style-d2o4t" href="https://www.youtube.com/watch?v=gJWNA3Fduek&amp;t=40" id="style-d2o4t">
              <div>
                <div class="k8E1vb oLJ4Uc style-Vc5bZ" id="style-Vc5bZ">
                  <img src="data:image/jpeg;base64,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" class="IOZdEc mNbAre">
                </div>
                <div class="fYFvJb">
                  <div class="tVRLD">
                    À partir de&nbsp;
                    <span>
                      00:40
                    </span>
                  </div>
                  <div class="paD5uf">
                    Dev Environment Overview
                  </div>
                </div>
              </div>
            </a>
          </li>
          <li>
            <a class="q9yZOe style-VIP4d" href="https://www.youtube.com/watch?v=gJWNA3Fduek&amp;t=124" id="style-VIP4d">
              <div>
                <div class="k8E1vb oLJ4Uc style-Vz5nw" id="style-Vz5nw">
                  <img src="data:image/jpeg;base64,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" class="IOZdEc mNbAre">
                </div>
                <div class="fYFvJb">
                  <div class="tVRLD">
                    À partir de&nbsp;
                    <span>
                      02:04
                    </span>
                  </div>
                  <div class="paD5uf">
                    Ordered Lists
                  </div>
                </div>
              </div>
            </a>
          </li>
          <li>
            <a class="q9yZOe style-vgVaC" href="https://www.youtube.com/watch?v=gJWNA3Fduek&amp;t=272" id="tsuid_42">
              <div>
                <div class="k8E1vb oLJ4Uc style-mUegq" id="style-mUegq">
                  <img class="IOZdEc mNbAre" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR3l__gy1CiQr78pGXVKOKi0qjuLiHmrdGn-uC_XOno_Q&amp;s">
                </div>
              
              </div>
            </a>
          </li>
        
        </ol>
      </div>
    </div>
    <div>
      <g-left-button class="wgbRNb bCwlI OZ5bRd T9Wh5 tHT0l pQXcHc style-8ooMt" id="style-8ooMt">
        <g-fab class="CNf3nf OvQkSb LhCR5d style-99EVz" id="style-99EVz">
          <span class="PUDfGe S3PB2d z1asCe">
            <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z">
              </path>
            </svg>
          </span>
        </g-fab>
      </g-left-button>
    </div>
    <div>
      <g-right-button class="wgbRNb VdehBf OZ5bRd T9Wh5 tHT0l style-Afhhy" id="style-Afhhy">
        <g-fab class="CNf3nf OvQkSb LhCR5d style-2ycaN" id="style-2ycaN">
          <span class="PUDfGe S3PB2d z1asCe">
            <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z">
              </path>
            </svg>
          </span>
        </g-fab>
      </g-right-button>
    </div>
  </g-scrolling-carousel> -->




<div style="margin-top:10px" class="sI5x9c">
<div class="row">
{{--@foreach($videos as $video)
  <div class="col-sm-4" style="margin-top:10px">
  <a class="X5OiLe vGvPJe" href="#fpstate=ive&amp;vld=cid:fb10f9d9,vid:20F_0LAHTmQ">
    <div class="WM9LLd">
      <div>
      <iframe width="560" height="115" src="{{$video->video}}" ></iframe>
      </div>
      <div class="NqpkQc style-o1LZl" id="style-o1LZl">
      </div>
      <div class="i5w0Le">
        <span class="z1asCe style-J4Lnt" id="style-J4Lnt">
          <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z">
            </path>
          </svg>
        </span>
      </div>
      <div class="BQavlc w2wy2">
        <span class="z1asCe style-BrwYe" id="style-BrwYe">
          <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M12 5.83L15.17 9l1.41-1.41L12 3 7.41 7.59 8.83 9 12 5.83zm0 12.34L8.83 15l-1.41 1.41L12 21l4.59-4.59L15.17 15 12 18.17z">
            </path>
          </svg>
        </span>
      </div>
      <div class="ZWiQ5 style-rRkDQ" id="style-rRkDQ">
        <div class="lR1utd">
          <span class="R4Cuhd">
            <div class="J1mWY">
              <div>
                5:31
              </div>
            </div>
          </span>
        </div>
      </div>
    </div>
  </a>
  </div>
   <div class="col-sm-6" style="margin-top:10px">
  <a class="X5OiLe" href="https://www.youtube.com/watch?v=20F_0LAHTmQ">
    <div class="WZIVy">
      <div class="uOId3b">
        <div class="fc9yUc tNxQIb ynAwRc OSrXXb">
          <span class="cHaqb">
          {{$video->titre}}         
        </span>
        </div>
      </div>
      <br>
      <div class="FzCfme">
        <span class="pcJO7e">
          <cite>
            Abajim
          </cite>
          <span>
            <span>
              ·
            </span>
            mohamed ali
          </span>
        </span>
        <div>
          <div class="V8fWH">
            10 minutes et 24&nbsp;secondes
          </div>
        </div>
        <div class="hMJ0yc">
          <span>
          {{$video->created_at}} 
          </span>
        </div>
      </div>
    </div>
  </a>
</div>
@endforeach--}}
<!-- </div>

<br>     -->
<!-- <g-more-link class="SenEzd oYWfcb OSrXXb RB2q5e">
  <a class="CHn7Qb pYouzb" href="/search?tbm=vid&amp;sxsrf=APwXEdcxqRzMBOeLRm9NKREgUFBzCVNI6A:1683404939456&amp;q=afficher+la+suite&amp;sa=X&amp;ved=2ahUKEwjptbeLxOH-AhVInaQKHcAiCbkQ8ccDegQICRAH">
    <hr class="rhHIGd">
    <div class="S8ee5 CwbYXd wHYlTd">
      <span class="p8VO6e HbX59e">
        <span class="z1asCe">
          <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z">
            </path>
          </svg>
        </span>
      </span>
      <span class="Z4Cazf OSrXXb">
        <span>
          Tout afficher
        </span>
      </span>
    </div>
  </a>
</g-more-link> -->





<!-- </div>
   </div> -->

   <div class="col-lg-11">
   <div style="padding:10px">
   <!-- <div id="pdf-viewer" style="display: flex; justify-content: space-between;height: 100vh; overflow-y: auto;"></div> -->
 <object data="{{asset($pdfPath)}}" type="application/pdf" width="100%" height="880px"  >
      <p>Unable to display PDF file. <a href="{{$pdfPath}}">Download</a> instead.</p>
    </object>
    </div>
</div>
   <div class="col-lg-1" style="
    padding-left: 0px;
    padding-right: 10px!important;
"> 

    <section >
 <div class="mt-2 p-0 rounded-sm shadow-lg border border-gray300 p-10 filters-container">
    <h4 class=" p-10 category-filter-title  font-20 font-weight text-dark-blue p-10">Courses</h4>

    <div class="form-group mt-20">

             
                        <select name="sort" class="form-control p-0" >
                            <option disabled selected>Mathématique</option>
                            <option value="top_rate" @if(request()->get('sort',null) == 'top_rate') selected="selected" @endif>Français</option>
                            <option value="top_sale" @if(request()->get('sort',null) == 'top_sale') selected="selected" @endif>Anglais</option>
                            <option value="top_rate" @if(request()->get('sort',null) == 'top_rate') selected="selected" @endif>Physique</option>
                            <option value="top_sale" @if(request()->get('sort',null) == 'top_sale') selected="selected" @endif>Philosophie</option>
                            <option value="top_rate" @if(request()->get('sort',null) == 'top_rate') selected="selected" @endif>Informatique</option>
                            <option value="top_sale" @if(request()->get('sort',null) == 'top_sale') selected="selected" @endif>Chimie</option>
                            <option value="top_sale" @if(request()->get('sort',null) == 'top_sale') selected="selected" @endif>Arabe</option>

                    
                        </select>
                        </div>

                       
               
         
    </div>

    <div class="mt-20 p-20 rounded-sm shadow-lg border border-gray300 filters-container">
    <h4 class="category-filter-title font-20 font-weight text-dark-blue">Options</h4>

    <div class="form-group mt-20"> 
    <br>
    <img src="/assets/default/img/iconres.jpg" class="img-cover rounded-circle" style="width:60px;margin-left:10px;height:60px!important;" >
      <br> <br>
     <img src="/assets/default/img/noteicontake.jpg" class="img-cover rounded-circle" style="width:60px;margin-left:10px;height:60px!important;" >
      <br> <br> 
     <img src="/assets/default/img/iconvoice.jpg" class="img-cover rounded-circle" style="width:60px;margin-left:10px;height:60px!important;" >
     </div>
    </div>

     <div class="mt-20 p-20 rounded-sm shadow-lg border border-gray300 filters-container">
    <h4 class="category-filter-title font-20 font-weight text-dark-blue">My Teacher</h4>

    <div class="form-group mt-20">       
         
                                <div class="user-search-card text-center d-flex flex-column align-items-center justify-content-center">
                                    <div class="user-avatar" style="width:65px;height:57px!important;">
                                        <img src="/store/870/avatar/617a4f7c09d61.png" class="img-cover rounded-circle" style="width:60px;height:60px!important;" >
                                    </div>
                                    <a href="">
                                   
                                        <span class="d-block font-14 text-gray mt-5">Jessica Wray</span>
                                    </a>
                                </div>
                         <br>
                           
                                <div class="user-search-card text-center d-flex flex-column align-items-center justify-content-center">
                                 <div class="user-avatar" style="width:65px;height:57px!important;">
                                        <img src="/store/1015/avatar/6417573dd820b.png" class="img-cover rounded-circle" style="width:60px;height:60px!important;" >
                                    </div>
                                    <a href="">
                                        <span class="d-block font-14 text-gray mt-5">Mohamed romdhane</span>
                                    </a>
                                </div>
                            
                         <br>
                                <div class="user-search-card text-center d-flex flex-column align-items-center justify-content-center">
                                    <div class="user-avatar" style="width:65px;height:57px!important;">
                                        <img src="/store/929/avatar/617a4f5d834c8.png" class="img-cover rounded-circle" style="width:60px;height:60px!important;" >
                                    </div>
                                    <a href="">
                                        <span class="d-block font-14 text-gray mt-5">Kate Willi</span>
                                    </a>
                                </div>
                </div>      </div>                 
                    
                 
                </section>
</div>
</div>
{{-- </div> --}}

@endsection

@push('scripts_bottom')
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>

<script>
    $.ajax({
    url: '/panel/init/scolaire/159',  // the URL for the route that handles the request
    type: 'GET',  // or 'GET', 'PUT', etc.
    data: {
        // your data here
    },
    success: function(response) {
        var url = "{{asset($pdfPath)}}";
    var pdfjsLib = window['pdfjs-dist/build/pdf'];

    pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

    var loadingTask = pdfjsLib.getDocument(url);
    loadingTask.promise.then(function(pdf) {
      var total_pages = pdf.numPages;

      for(let pageNumber = 1; pageNumber <= total_pages; pageNumber++){
        // Get page
        pdf.getPage(pageNumber).then(function(page) {
          var scale = 1.1;
          var viewport = page.getViewport({scale: scale});
           
          var canvas = document.createElement('canvas');
          var context = canvas.getContext('2d');
          canvas.height = viewport.height;
          canvas.width = viewport.width;

          var renderContext = {
            canvasContext: context,
            viewport: viewport
          };
          var renderTask = page.render(renderContext);
          var icon1X = 175;
    var icon1Y = 220;
    var icon1Width = 10;
    var icon1Height = 10;
    var icon2X = 36;
    var icon2Y = 60;
    var icon2Width = 9;
    var icon2Height = 9;
    var icon3X = 36;
    var icon3Y = 172;
    var icon3Width = 9;
    var icon3Height = 9;
    var icon4X = 175;
    var icon4Y = 134;
    var icon4Width = 10;
    var con4Height = 10;
          canvas.addEventListener('click', function(e) {
            var rect = canvas.getBoundingClientRect();
                var x = e.clientX - rect.left+50;
                var y = e.clientY - rect.top;
                console.log(x);
             if (x >= icon1X && x <= icon1X + icon1Width && y >= icon1Y && y <= icon1Y + icon1Width) {
                  window.location.href = "/panel/scolaire/159?icon=1&page=6";
                 }
                if(x >= icon2X && x <= icon2X + icon2Width){
                    window.location.href = "/panel/scolaire/159?icon=2&page=6";
                }
                if(x >= icon3X && x <= icon3X + icon3Width){
                    window.location.href = "/panel/scolaire/159?icon=3&page=6";
                } 
                if(x >= icon4X && x <= icon4X + icon4Width && y >= icon4Y && y <= icon4Y + icon4Width){
                    window.location.href = "/panel/scolaire/159?icon=4&page=6"; 
                }
          });

          renderTask.promise.then(function () {
            document.getElementById('pdf-viewer').appendChild(canvas);
          });
        });
      }

      
    });
    },
    error: function(jqXHR, textStatus, errorThrown) {
        // handle any errors
    }
});
   
  </script>
@endpush
