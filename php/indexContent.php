<div class="height650" id="bg-picIndex1" >
    <!-- //bg -->
</div>

<div class=" mainDiv bg-grey">
    <!-- sticky -->
    <div  class="text-center sticky">
        <h4> <strong>Focimezek</strong> - A&nbspgyűjteményem</h4>
    </div>
    <!-- A honlap célja -->
    <div id="aHonlapCelja"></div><br>
    <div class="row" >
        <div class="col-8">
            <h2>A honlap célja</h2>
            <h4>Megosztani Veletek a gyűjteményt, böngésszetek kedvetekre! </h4>
            <p>
                Sziasztok, Kaiser Rezső vagyok. A mezeket nagyon régóta gyűjtöm, a focizás mellett ez az egyik kedvenc elfoglaltságom.<br>
                .... <br>
                .... <br>
                ....
            </p>
            <button class="btn btn-secondary pull-left">LIKE</button>
                                <!-- LÁJKOLJ- adatbázisból kiolvassa, lájkszámláló -->
        </div>
        <div class="col-3">
            <img class="img img-rounded" src="public/resources/pics/profile_pics/basic.jpg" alt="IT'S ME">
        </div>
    </div><!--endof #honlapCelja-->


    <div id="kedvencek"></div><br>
    <div class="bg-info" >
        <h2>A kedvenc mezeim</h2>
                <div id="carouselIndex" class="carousel slide carousel-fade mt-1 indexCarausel" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselIndex" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselIndex" data-slide-to="1"></li>
                    <li data-target="#carouselIndex" data-slide-to="2"></li>
                    <li data-target="#carouselIndex" data-slide-to="3"></li>
                    <li data-target="#carouselIndex" data-slide-to="4"></li>
                </ol>

                <div class="carousel-inner text-center" role="listbox">
                    <div class="carousel-item active">
                        <p>Ez azért tetszik, mert...</p>
                        <img src="public/resources/pics/carousel/1.jpg" alt="mez1" width="250px" >
                    </div>
                    <div class="carousel-item">
                        <p>Ez meg azért tetszik, mert...</p>
                        <img src="public/resources/pics/carousel/2.jpg" alt="mez2" width="250px" >
                    </div>
                    <div class="carousel-item">
                        <p>Ez mert...</p>
                        <img src="public/resources/pics/carousel/1.jpg" alt="mez3" width="250px" >
                    </div>
                    <div class="carousel-item">
                        <p>Ez azért mert...</p>
                        <img src="public/resources/pics/carousel/2.jpg" alt="mez4" width="250px" >
                    </div>
                    <div class="carousel-item">
                        <p>Ez nem is tetszik.</p>
                        <img src="public/resources/pics/carousel/1.jpg" alt="mez5" width="250px" >
                    </div>
                </div>

                <a class="carousel-control-prev" href="#carouselIndex" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#carouselIndex" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
        </div>
    </div><!--endof kedvencek-->


    <div id="linkek"></div><br>
    <div class="bg-grey "  >
        <H2>Linkek</H2>
        <h4 class="pb-3">Amennyiben érdekel Téged a téma, az alábbi linkeken találsz még mezeket. :)</h4>
        <div class="container">
            <div class="row text-center">
                <div class="col-sm-4 pb-2" >
                    <div class="thumbnail bordered">
                        <a href="http://stevensfootballshirts.net/index2.html" target="_blank">
                            <img src="public/resources/pics/links/stevens.jpg" alt="stevensfootballshirts.net"/>
                        </a>
                        <p><strong>Steven futball mez gyűjteménye</strong></p>
                        <p>Szuper kis oldal, nekem nagyon tetszik</p>
                    </div>
                </div><!--endof LINK-->
                <div class="col-sm-4 pb-2">
                    <div class="thumbnail bordered">
                        <a href="https://www.kummerbube.com/" target="_blank">
                            <img src="public/resources/pics/links/kummerbube_banner.jpg" alt="kummerbube.com"/>
                        </a>
                        <p><strong>Egy magángyűjtemény, szuper!</strong></p>
                        <p>Azért tetszik, mert jól néz ki. </p>
                    </div>
                </div><!--endof LINK-->
                <div class="col-sm-4 pb-2">
                    <div class="thumbnail bordered">
                        <a href="http://fcbtrikots.ch/" target="_blank">
                            <img src="public/resources/pics/links/trikots.de.jpg" alt="fcbtrikots.ch"/>
                        </a>
                        <p><strong>Steven futballmez gyűjteménye</strong></p>
                        <p>Szuper kis oldal, nekem nagyon tetszik</p>
                    </div>
                </div><!--endof LINK-->
            </div><!--endof ROW-->
    </div><!--endof #linkek-->

     <div class="container-fluid height650 jumbotron" id="bg-picIndex2" >
    </div>

    <div id="kapcsolat"><br>
        <div class="jumbotron">
            <h2>Kapcsolat</h2>
            <h4 class="py-2">Amennyiben szeretnéd felvenni velem a kapcsolatot, üzenj nekem!</h4>
            <div class="">
                    <div class="row">
                        <!--myContact-->
                        <div class="col-sm-5 py-2">
                            <p>Add meg az adataidat, hogy tudjak válaszolni. </p>
                            <p><span class="fa fa-car fa-2x"></span>&nbsp&nbsp&nbsp Szeged, Magyarország</p>
                            <p><span class="fa fa-envelope fa-2x"></span>&nbsp&nbsp&nbsp myemail@something.com</p>
                        </div><!--endof myContact-->
                        <!--Message me-->
                        <div class="col-sm-7 py-2">
                            <form method="" action="">
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <input class="form-control" id="name" name="name" placeholder="Név" type="text" required>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <input class="form-control" id="email" name="email" placeholder="Email" type="email"      required>
                                    </div>
                                </div>
                                    <textarea class="form-control" id="comments" name="comments" placeholder="Üzenet" rows="5"></textarea><br>
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                         <button class="btn btn-secondary pull-right" type="submit">Küldés</button>
                                    </div>
                                </div>
                            </form><!--endof form-->
                        </div><!--endof sendMe-->
                    </div><!--endof row-->
            </div>
        </div><!--endof jumbotron -->
    </div><!--endof kapcsolat-->


</div> <!--endof Maindiv-->







<?php
