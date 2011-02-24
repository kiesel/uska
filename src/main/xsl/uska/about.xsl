<?xml version="1.0" encoding="iso-8859-1"?>
<!--
 ! About state
 !
 ! $Id: events.xsl 4970 2005-04-10 17:05:20Z kiesel $
 !-->
<xsl:stylesheet
 version="1.0"
 xmlns:exsl="http://exslt.org/common"
 xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
 xmlns:func="http://exslt.org/functions"
 extension-element-prefixes="func"
>

  <xsl:include href="layout.xsl"/>

  <xsl:template name="context">
    <xsl:call-template name="default_subnavigation">
      <xsl:with-param name="items">
        <items>
          <item href="{func:link('about/reports')}">Spielberichte</item>
          <item href="{func:link('about/pictures')}">Fotos</item>
        </items>
      </xsl:with-param>
    </xsl:call-template>
  </xsl:template>
  
  <xsl:template name="content">
    Hallo liebe Besucher von uska.de,<br/>
    <br/>
    willkommen auf unserer Website. U.S.K.A. e.V. - so hei�t unser Verein. Was<br/>
    verbirgt sich dahinter? United Schlund Karlsruhe e.V. (kurz USKA) - ein<br/>
    Verein f�r Fu�ball und andere Sportfreuden. Gegr�ndet wurde USKA im Jahre<br/>
    2000 von Mitarbeitern der Schlund + Partner AG und der Puretec GmbH, beide<br/>
    heute unter dem Dach der 1&amp;1 Internet AG vereint. Ziel damals wie heute:<br/>
    Fu�ball spielen, locker bleiben, Spa� haben.<br/>
    <br/>
    Spa� haben.... . Warum dann ausgerechnet ein eingetragener Verein, werden<br/>
    manche denken. Nun ja, versuchen Sie mal in einer aufstrebenden Gro�stadt<br/>
    mit Hauptstadtambitionen ohne Vereinsstatus eine Sportst�tte zu finden.<br/>
    Fu�ballpl�tze wie Sporthallen f�r den Winterbetrieb sind schwer zu haben.<br/>
    Eingetragene Vereine haben es vor allem in Verhandlungen mit dem st�dtischen<br/>
    Sportamt leichter als lose Haufen vagabundierender Freizeitkicker.<br/>
    <br/>
    Warum 'United Schlund Karlsruhe'? Ganz klar, die Gr�nder waren und sind immer<br/>
    noch 'Schlundies', also Kollegen des gr��ten Webhosters dieser Welt -<br/>
    Schlund + Partner. Das 'United' ist dabei eine klare Huldigung an den<br/>
    englischen Traditionsclub sowie gleichzeitig Ausdruck des Gedankens, dass<br/>
    Sport und Gemeinsamkeit stets Hand in Hand gehen.<br/>
    <br/>
    Um den Eindruck zu korrigieren, hier sei schn�der Betriebssport am Werk.<br/>
    Nat�rlich hat USKA auch Angeh�rige, die selbst nichts mit den genannten<br/>
    Unternehmen zu tun haben; Freunde des Vereins halt.<br/>
    <br/>
    Bei USKA steht wie schon gesagt der Spa� im Vordergrund. Wir spielen in<br/>
    keiner Liga, denn der Sonntag ist uns noch heilig. Den brauchen wir zur<br/>
    Rekonvaleszenz nach der Samstagabend-Party. Daf�r wird unter der Woche - in<br/>
    der Regel dienstags - kr�ftig losgekickt. Konditions- und Ausdauertraining<br/>
    findet man allerdings eher selten. Die Mitglieder sind angehalten, ihren<br/>
    inneren Schweinehund selbst zu �berwinden und der Rest der Woche dazu zu<br/>
    nutzen, ihr Blut mit Sauerstoff anzureichern. Man muss stets bedenken: Wir<br/>
    sind hier in Karlsruhe. USKAs Vereinsmentalit�t ist eher eine<br/>
    badisch-s�dl�ndische. Das hei�t das Motto durchaus schon mal: 'Kommscht<br/>
    heut' net? Alla, kommscht halt morge' Das eher preu�isch-verbissen<br/>
    Disziplinierte �berlassen wir lieber Kollegen von anderen Standorten unseres<br/>
    Unternehmens.<br/>
    <br/>
    Gespielt wird winters in der Regel in den R�umlichkeiten der Sportschule des<br/>
    Badischen Fu�ballverbandes, sommers auf dem Gel�nde des SSC Karlsruhe in der<br/>
    Waldstadt. Nach dem Spiel ist bekanntlich vor dem Spiel. Da kommt uns ein<br/>
    Weizenbier in gem�tlicher Runde im nahen Biergarten durchaus schon einmal<br/>
    gelegen. Nat�rlich darf es - schlie�lich reden wir �ber Sport - gerne auch<br/>
    eine politisch korrektere Apfelschorle sein.<br/>
    <br/>
    Nur bei einem Punkt h�rt auch f�r USKA der Spa� auf: Das Turnier zum<br/>
    Sommerfest unseres Br�tchengebers weckt Emotion und l�sst gleichzeitig<br/>
    Adrenalin spritzen. Hier geben auch wir alles. Da geht es um die Ehre.<br/>
    Schlie�lich spielen wir da u.a. exakt gegen jene 'Preu�en', wie ich sie oben<br/>
    bereits beschrieb. Nicht nur historisch Interessierte wissen: Seit 1848 hat<br/>
    da Baden noch eine Scharte auszuwetzen. Damals wie heute schickte ein<br/>
    alleinherrschender K�nig seine Truppen, den liberalen Badenern den Gar<br/>
    auszumachen. Ihr seht: Hier geht es an Eingemachte.<br/>
    <br/>
    Aber sonst gilt: Allein elf Freunde m�sst ihr sein!    <br/>
  </xsl:template>
</xsl:stylesheet>
