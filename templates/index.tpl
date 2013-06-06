{config_load file="test.conf" section="setup"}
{include file="header.tpl" title=foo}

<header>
    <div class="content">
        <div id="logo">
            <a href="" alt=""><img src="img/logo.png" alt=""/></a>
        </div>
        <div id="contact"> 
            <p> Luni-Vineri: 8-20<br/>
                Sambata-Duminica: 10-18</br>
                Contact: 0756 318 976</br>
                <font style="float: right; margin-right: 45px;">: 0760 489 168</font></br>
                E-mail: office@wildride.ro
            </p>
        </div>
    </div>    
</header>
<section id="container">
    <div class="content">
        <h1>Hi, {$customer['nume']} {$customer['prenume']}</h1>
        {$customer['message']}
        <p class="signature">{$sender['name']}</br>
           {$sender['signature']}
        </p>
    </div>
</section>

{include file="footer.tpl"}
