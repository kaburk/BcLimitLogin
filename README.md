# BcLimitLogin

BcLimitLogin(ログイン思考制限)プラグインは、ログイン時にログインID、パスワードを何度か間違えると暫くログインできなくなるbaserCMS4系（4.4.7以降）専用のプラグインです。
初期状態では、10分間に5回間違えると10分ほどログインできなくなります。
サイドログインするには暫く時間をおいてからログインしてください。

ダッシュボードの「最近の動き」にも、ログイン、ログアウトの動作を記録します。
ログイン履歴を別で記録しているので、一覧でログイン時の詳細な情報（未ログイン、ログイン、ログアウトなど）を閲覧・履歴を削除することもできます。

## Installation

1. 圧縮ファイルを解凍後、BASERCMS/app/Plugin/BcLimitLogin に配置します。
2. 管理システムのプラグイン管理に入って、表示されている BcLimitLogin プラグイン を有効化して下さい。
3. 有効化すると、
4. プラグインメニュー内に「ログイン履歴」メニューから一覧を確認できます。

## Caution

-  baserCMS 4.4.7で導入された機能を利用しているので、baserCMS 4.4.7以前のバージョンでは動作しません。

## Thanks

- [http://basercms.net/](http://basercms.net/)
- [http://wiki.basercms.net/](http://wiki.basercms.net/)
- [http://cakephp.jp](http://cakephp.jp)
- [Semantic Versioning 2.0.0](http://semver.org/lang/ja/)
