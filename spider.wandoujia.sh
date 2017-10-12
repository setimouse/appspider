for pkgname in `cat package.txt | tr -d "\r"`
do
	url="http://www.wandoujia.com/apps/"$pkgname
	echo $url
	out="package/"$pkgname
	mkdir -p $out
	curl -s -o ${out}"/wandoujia" "$url"
done;
