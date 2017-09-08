#!/bin/sh
#get shell path
coredir=$(cd $(dirname $0); pwd)
composerpharfile=${coredir}/composer.phar
contentsdesignerdir=${coredir}/plugins/ContentsDesigner
contentsdesignerfiledir=${coredir}/ContentsDesignerFiles
npmBasePath=${coredir}/node_modules
npmSymbolPath=${coredir}/webroot/node_modules

#composer.phar check
if [ ! -e ${composerpharfile} ]; then
echo "composer.phar not exist"
exit 0
fi
# core setting
cd ${coredir};
php ${composerpharfile} install --no-interaction
npm install;

# node_modulesのシンボリックリンク
if [ ! -L ${npmSymbolPath} ]; then
    ln -s ${npmBasePath} ${npmSymbolPath}
fi

# contents_file用のディレクトリ作成
tmpdir=${coredir}/tmp/cache/files
filedir=${coredir}/files
contentsdesignerfiledir=${coredir}/ContentsDesignerFiles
if [ ! -e ${tmpdir} ]; then
    mkdir ${tmpdir};
fi
if [ ! -e ${filedir} ]; then
    mkdir ${filedir};
fi
if [ ! -e ${contentsdesignerfiledir} ]; then
    mkdir ${contentsdesignerfiledir};
fi
chmod 777 ${tmpdir};
chmod 777 ${filedir};
chmod 777 ${contentsdesignerfiledir};

# git-pre-commitのコピー
if [ -e .git ]; then
    cp git-pre-commit .git/hooks/pre-commit;
    chmod -R +x .git/hooks/pre-commit;
fi

#cache clear
cd ${coredir};
bin/cake cache clear_all
