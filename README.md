# pdf2jpg(phpによるファイル自動変換演習(2回目の挑戦))

自主的に勉強しているものである。
## 1.目的
主にphpプログラミングの演習。  
また、GitHubでは他のユーザがレポジトリを見たとき、README.mdが表示される。  
mdファイル(MarkDown記法のテキストファイル)にはテキストの他、画像を挿入することができる。  
また、特に大学の授業のノートとしてリポジトリを公開している場合、他人に最も読んでもらいたいのはpdfファイルであったりすることも多い。  
そこで、pdfファイルをjpgファイルに変換して、画像としてREADME.mdに挿入するということを考えた。  
このプロセスを自動化するためのプログラムの作成を目的とする。
## 2.使用環境、ソフト
･Windows 10 Pro  
･[xampp (PHP 7.2.12)](https://www.apachefriends.org/jp/index.html) (Control Panelのバージョンはv3.2.2であった)  
･ImageMagick  
･Microsoft Word 2016

## 3.実験と結果
実験日: 2018/11/25
#### 3-1-1.実験1 端末のサーバ化[1]
①参考サイト[1]に従ってXAMPPをインストールした。  
但し、すべてのソフトを選択してインストールした。  
また、xamppをインストールしたディレクトリは`c:\xampp`である。
②http\://localhost/ にアクセスした。
#### 3-1-2.実験1の結果
図3-1-2のようなページが表示された。  
![図3-1-2](https://raw.githubusercontent.com/17ec084/pdf2jpg/secondChallenge/data/3_1_2.png "図3-1-2")  
<Div Align="center">図3-1-2 実験1の結果</Div>  
#### 3-1-3 実験2 拡張モジュールの確認
①次のようなファイルtest.php[2]を作成し、`C:\xampp\htdocs`にコピーした。このディレクトリにコピーすることは、サーバへのアップロードに相当する。  

```php:3-1-1
<?php

$im = new Imagick();
//画像を生成したいPDFを読み込む
$im->readImage('hoge.pdf');
//ページ数を取得する
$totalPage = $im->getImageScene();

for ($i = 0; $i <= $totalPage; $i++) {
	//PDFのページ
	$im->setImageIndex($i);
	//サムネイルサイズ 640pxに収める
	$im->thumbnailImage(640, 640, true);
	//シャープ
	$im->sharpenImage(0, 1);
	//生成
	$im->writeImage('out_' . $i . '.jpg');
}

$im->destroy();

?>

```


<!--
①次のようなファイルtest.phpを作成し、サーバにアップロードした。[1]  

```php:3-1-1
<?php

$im = new Imagick();
//画像を生成したいPDFを読み込む
$im->readImage('hoge.pdf');
//ページ数を取得する
$totalPage = $im->getImageScene();

for ($i = 0; $i <= $totalPage; $i++) {
	//PDFのページ
	$im->setImageIndex($i);
	//サムネイルサイズ 640pxに収める
	$im->thumbnailImage(640, 640, true);
	//シャープ
	$im->sharpenImage(0, 1);
	//生成
	$im->writeImage('out_' . $i . '.jpg');
}

$im->destroy();

?>

```

②Microsoft Word 2016で「hoge.pdf」とだけ書いた文章hoge.pdfを作成した。  
③WWWブラウザで、サーバにアップロードしたtest.phpを閲覧した。  

#### 3-1-2.実験1の結果
実験1の結果、次のようにFatal errorが表示された。

> <br />
> <b>Fatal error</b>:  Uncaught Error: Class 'Imagick' not found in /storage/ssd3/785/2791785/public_html/test.php:3
> Stack trace:
> #0 {main}
>  thrown in <b>/storage/ssd3/785/2791785/public_html/test.php</b> on line <b>3</b><br />

このことから、サーバにはImageckというクラスが用意されていない、即ちImageMagickがインストールされていないということが分かった。

#### 3-2-1.実験2 ImageMagickのインストール
①http://pecl.php.net/package/imagick
[2]
から最新のtgzファイルをダウンロードした。
②php.iniファイルの設定を変更し、ImageMagickを有効にしようと試みた。

#### 3-2-2.実験2の結果
①のファイルをサーバにダウンロードする手段がなかった。  
また、②php.iniファイルにアクセスすることができなかった。  

## 4.反省
使用したサーバでは、サーバにphpの拡張モジュールを追加出来ないようになっていた。  
その為、次回挑戦する際には  
・自宅サーバを立ち上げる  
・有料のレンタルサーバを借りる  
・外部サイトに頼る  
のいずれかの方法をとることになるだろう。

一つ目の方法をとる場合、常に稼働できる端末を用意しなければならないので、低消費電力のマイコンを購入し、サーバとして利用することになると予想される。  
二つ目の方法はおそらくとらない。  
三つ目の方法の場合、例えば次のような手段を講じることになるだろう。  
・外部サイトが、postされたpdfファイルのURIを受け取って、画像ファイルを返却する仕様である場合  
→まず、画像と称してREADME.mdのどこかに「サーバ?pass=hoge.pdf」を埋め込む。  
次にサーバは、get送信されたhoge.pdfというファイルのパスをそのまま外部サイトへpostする。
そして外部サイトが返却した画像をそのまま返す  

## 5.参考サイト
[1]http://www.kent-web.com/www/chap1.html  
[2]http://pecl.php.net/package/imagick  
    
-->