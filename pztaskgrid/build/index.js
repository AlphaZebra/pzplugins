(()=>{"use strict";var e,t={5453:()=>{const e=window.wp.element,t=window.wp.blocks,l=(window.wp.i18n,window.wp.blockEditor),r=window.wp.components,n=JSON.parse('{"u2":"pz/pztaskgrid"}');(0,t.registerBlockType)(n.u2,{icon:{src:(0,e.createElement)("svg",{viewBox:"0 0 36 36",xmlns:"http://www.w3.org/2000/svg","aria-hidden":"true",role:"img",class:"iconify iconify--twemoji",preserveAspectRatio:"xMidYMid meet",fill:"#000000"},(0,e.createElement)("g",{id:"SVGRepo_bgCarrier","stroke-width":"0"}),(0,e.createElement)("g",{id:"SVGRepo_tracerCarrier","stroke-linecap":"round","stroke-linejoin":"round"}),(0,e.createElement)("g",{id:"SVGRepo_iconCarrier"},(0,e.createElement)("path",{fill:"#E1E8ED",d:"M23.283 23.275s1.374 1.635 2.733 10.047c.143.883.201 1.775.217 2.678H36V7.448C31.613 3.975 25.601 3.259 18.322 5.69c0 0-5.408-3-6.147-3.739c-.719-.72-1.857-1.556-1.235.35c.364 1.112.764 2.373 2.358 4.862c-3.436 2.036-4.513 4.68-8.558 13.341C1.652 27.12.08 29.269.937 31.797c1.13 3.337 5.316 5.595 8.844 3.021c1.919-1.4 2.246-3.913 6.225-6.223c3.653-.065 7.277-1.604 7.277-5.32z"}),(0,e.createElement)("path",{fill:"#292F33",d:"M36 6.012C27.665.301 14.354 1.473 15.909 6.19C25.51 4.328 31.77 7.731 36 13.358V6.012z"}),(0,e.createElement)("path",{fill:"#292F33",d:"M19.663 5.763c-2.878.233-7.28 1.765-9.42 4.137c0 0-.005-5.317 3.689-5.784c6.172-.779 5.809.363 5.809.363l-.078 1.284z"}),(0,e.createElement)("path",{fill:"#E1E8ED",d:"M16.357 1.056c.558 1.155 4.006 1.79 5.056 6.029c1.051 4.24-3.134 2.951-4.356.855c-1.361-2.334-1.828-4.162-1.867-5.679c-.021-.801.039-3.538 1.167-1.205z"}),(0,e.createElement)("path",{fill:"#66757F",d:"M16.596 2.838c1.103.968 2.448 2.472 2.65 3.955c.202 1.483-1.125.988-1.736-.372c-.612-1.359-.753-2.779-1.134-3.233c-.38-.454.22-.35.22-.35z"}),(0,e.createElement)("path",{fill:"#292F33",d:"M16.94 15.525a1.244 1.244 0 1 1-2.489 0a1.244 1.244 0 0 1 2.489 0z"}),(0,e.createElement)("path",{fill:"#E1E8ED",d:"M10.354 9.924c-.033-.017-.075-.014-.111-.024c-1.543 2.033-2.92 5.102-5.49 10.604c-1.356 2.903-2.42 4.946-3.116 6.538c1.628.226 3.285-1.442 3.945-3.271c.673-1.866 3.215-5.652 4.927-7.778c1.712-2.127 1.561-5.144-.155-6.069z"}),(0,e.createElement)("path",{fill:"#292F33",d:"M28.188 6.312s-2.296 6.947-2.302 8.947c-.011 3.803-2.687 7.801-2.687 7.801l1.342 3.422s3.25-3.04 3.938-10.228c.571-5.973 2.566-7.667 2.566-7.667l-2.857-2.275zm5.874 3.126S31.056 13.073 30 19c-1.438 8.062-4.857 9.746-4.857 9.746l.482 2.441s5.281-3.056 6.632-9.115C33.875 14.812 36 13.358 36 13.358l-1.938-3.92zm-30.812 14c.688-.714 3.017 3.808 4.53 4.884c1.589 1.13 5.469.935 5.701 2.162c-1.668 1.704-2.763 4.273-4.84 4.988c-2.078.716-5.71.677-7.238-2.647c-1.528-3.325-.403-4.7.222-6.137s1.458-2.938 1.625-3.25z"}),(0,e.createElement)("path",{fill:"#66757F",d:"M4.222 29.917c0 .881-.532 1.594-1.187 1.594s-1.187-.713-1.187-1.594c0-.882.532-1.596 1.187-1.596s1.187.714 1.187 1.596z"}),(0,e.createElement)("path",{fill:"#292F33",d:"M25.954 32.945s4.608-1.57 6.108-3.383S36 24 36 24v6.375S34.812 32 32.312 33.313c-1.586.832-6.092 2.251-6.092 2.251l-.266-2.619zM25.01 6.08S24.063 9 23.813 12s-1.125 4.875-1.938 6.188c.312-4.25-.688-5.875-.125-8.125s.87-4.32.87-4.32s.63-.368 1.255-.305s1.135.642 1.135.642zM4.753 20.504s3.934-.379 5.747.871s5.332 7.323 5.332 7.323l-1.134.753s-1.697-4.639-4.76-6.076s-6-1.188-6-1.188l.815-1.683z"}),(0,e.createElement)("path",{fill:"#292F33",d:"M5.605 18.678s5.516-.358 6.958 1.509c2.75 3.562 3.831 5.01 4.447 8.349l1.785-.307c-.794-2.917-2.607-8.104-5.919-10.292s-6.25-1.688-6.25-1.688l-1.021 2.429zm12.27-5.99c-.625.688 2 3.312 1.125 5.5s-.375 5.25.125 6.625s1.26 2.839 1.26 2.839l1.622-1.146S21.75 25 21 22.813s-.688-2.25-.375-4.438S18.5 12 17.875 12.688zm-2.83-5.859s1.142 2.046 1.08 3.046s-.062 2.688-.625 3.062s-.812-2-1.188-3.062s-1.064-2.258-1.064-2.258s1.469-1.428 1.797-.788zm-3.544 1.79s1.793 1.398 1.73 2.398s1.144 2.607.581 2.982s-1.938-1.25-2.312-2.312S10.243 9.9 10.243 9.9s.929-1.921 1.258-1.281zm-2.563 3.193s1.522.981 1.938 1.75c.415.768 2.11 1.387 1.938 1.875c-.173.488-1.977-.098-2.688-.75c-.711-.652-2.345-.579-2.345-.579l1.157-2.296z"})))},edit:function(t){const{attributes:n,setAttributes:c}=t,[a,i]=(0,e.useState)({top:"50px",left:"10%",right:"10%",bottom:"50px"}),s=window.location.origin+"/wp-content/plugins/pzprojectgrid/includes/assets/project-list.png";return(0,e.createElement)("div",{...(0,l.useBlockProps)()},(0,e.createElement)(l.InspectorControls,null,(0,e.createElement)(r.PanelBody,{title:"When Adding/Editing"},(0,e.createElement)(r.TextControl,{label:"URL for Task Add form",value:n.addURL,onChange:e=>c({addURL:e})}),(0,e.createElement)(r.TextControl,{label:"URL for Task Edit form",value:n.editURL,onChange:e=>c({editURL:e})}),(0,e.createElement)(r.TextControl,{label:"Advanced internal app name",value:n.appName,onChange:e=>c({appName:e})}))),(0,e.createElement)("table",null,(0,e.createElement)("tr",null,(0,e.createElement)("td",null,(0,e.createElement)("img",{src:s})),(0,e.createElement)("td",null,(0,e.createElement)("h4",null,"PZ Task Grid")))))},save:function(){return null}})}},l={};function r(e){var n=l[e];if(void 0!==n)return n.exports;var c=l[e]={exports:{}};return t[e](c,c.exports,r),c.exports}r.m=t,e=[],r.O=(t,l,n,c)=>{if(!l){var a=1/0;for(p=0;p<e.length;p++){l=e[p][0],n=e[p][1],c=e[p][2];for(var i=!0,s=0;s<l.length;s++)(!1&c||a>=c)&&Object.keys(r.O).every((e=>r.O[e](l[s])))?l.splice(s--,1):(i=!1,c<a&&(a=c));if(i){e.splice(p--,1);var o=n();void 0!==o&&(t=o)}}return t}c=c||0;for(var p=e.length;p>0&&e[p-1][2]>c;p--)e[p]=e[p-1];e[p]=[l,n,c]},r.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={826:0,431:0};r.O.j=t=>0===e[t];var t=(t,l)=>{var n,c,a=l[0],i=l[1],s=l[2],o=0;if(a.some((t=>0!==e[t]))){for(n in i)r.o(i,n)&&(r.m[n]=i[n]);if(s)var p=s(r)}for(t&&t(l);o<a.length;o++)c=a[o],r.o(e,c)&&e[c]&&e[c][0](),e[c]=0;return r.O(p)},l=self.webpackChunkpztaskgrid=self.webpackChunkpztaskgrid||[];l.forEach(t.bind(null,0)),l.push=t.bind(null,l.push.bind(l))})();var n=r.O(void 0,[431],(()=>r(5453)));n=r.O(n)})();