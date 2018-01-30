#access {
    
    display: block;
    margin: 0 auto 6px 55px;
    position: absolute;
    top: 100px;
    z-index: 9999;
}
#access ul {
    font-size: 13px;
    list-style: none;
    margin: 0 0 0 -0.8125em;
    padding-left: 0;
}
#access li {
    position: relative;
    padding-left: 11px;
    margin:0 0 3px 0;
}
#access a {
    background: #0f84e8; /* Show a solid color for older browsers */
    color: #eee;
    display: block;
    line-height: 3.333em;
    padding: 0 10px 0 20px;
    text-decoration: none;
}
#access ul ul {
    display: none;
    float: left;
    margin: 0;
    position: absolute;
    top: 0;
    left: 100%;
    width: 188px;
    z-index: 99999;
    opacity: 0.70;
    margin-left: -7px;
}
#access ul ul ul {
    left: 100%;
    top: 0;
}
#access ul ul a {
    background: #0f84e8;
    font-size: 13px;
    font-weight: normal;
    height: auto;
    line-height: 1.4em;
    padding: 10px 10px;
    width: 168px;
}
#access li:hover > a,
#access ul ul :hover > a,
#access a:focus {
    background: #efefef;
}
#access li:hover > a,
#access a:focus {
    background: #f9f9f9; /* Show a solid color for older browsers */
    background: -moz-linear-gradient(#f9f9f9, #e5e5e5);
    background: -o-linear-gradient(#f9f9f9, #e5e5e5);
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#f9f9f9), to(#e5e5e5)); /* Older webkit syntax */
    background: -webkit-linear-gradient(#f9f9f9, #e5e5e5);
    color: #373737;
}
#access ul li:hover > ul {
    display: block;
}
#access .current-menu-item > a,
#access .current-menu-ancestor > a,
#access .current_page_item > a,
#access .current_page_ancestor > a {
    font-weight: bold;
}
