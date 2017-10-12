for pkgname in `cat package.txt | tr -d "\r"`
do
	url="http://www.appchina.com/app/"$pkgname
	echo $url
	out="package/"$pkgname
	mkdir -p $out
	curl -s -o ${out}"/appchina" "$url"
done;
