# WordPress ローカル検証・プラグイン開発環境

WordPressの動作検証と自作プラグイン開発のためのローカル環境です。Docker DesktopとWordPress公式の`@wordpress/env`（wp-env）を使い、開発用・テスト用のWordPressを起動します。

## 前提条件

- Docker Desktopが起動していること
- Node.js 22.13.0以上とnpm
- 8888・8889番ポートが空いていること

動作確認済みのホストはApple Silicon Macです。WindowsではWSL 2（Ubuntu）＋Docker Desktopを推奨します。[Windows構築手順](00.ドキュメント/06.Windows構築手順.md)に導入方法を記載しています（Windows実機では未検証）。

## セットアップ

```bash
git clone https://github.com/uemakm/wordpress_dev.git
cd wordpress_dev
npm ci
npm start
npm run seed
```

初回はコンテナの取得・ビルドに時間がかかります。`npm run seed`は開発環境に本文付きの公開記事を30件作成します。タイトルは`No.1`〜`No.30`で始まり、同じスラッグの記事はスキップするため、繰り返し実行しても重複・上書きしません。

| 用途 | URL |
| --- | --- |
| 開発サイト | http://localhost:8888/ |
| 開発管理画面 | http://localhost:8888/wp-admin/ |
| テストサイト | http://localhost:8889/ |

ログインはwp-envの既定のローカル検証用アカウントを使用します。[wp-env公式仕様](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/)を参照してください。

## 構成

| 項目 | 設定 |
| --- | --- |
| WordPress | 7.1.4 |
| PHP | 8.3系列 |
| MariaDB | 12.3.3 |
| wp-env | 12.1.0 |

```text
.
├── .wp-env.json             # WordPress・PHP・DB・共有設定
├── package.json             # 操作コマンドと開発依存
├── package-lock.json        # npm依存の固定
├── 00.ドキュメント/          # 構成・構築手順・検証記録
├── 01.plugins/              # 自作プラグイン（現在は空）
├── 02.検証成果物/            # ログ・退避データ（Git対象外）
└── 03.初期データ/            # サンプル記事の投入スクリプト
```

## 日常操作

```bash
npm start                         # 起動
npm stop                          # 停止
npm run logs                      # ログを表示
npm run seed                      # 開発環境にサンプル記事を投入
npm run env -- run cli wp core version
```

設定変更後は`npm start -- --update`で反映します。通常の停止には`npm stop`を使います。DBリセットや環境破棄はデータを失うため、必要なデータを退避してから実施してください。

## データの管理

Gitには環境設定、文書、初期データの投入スクリプトを保存します。WordPressのDB・アップロード画像・コンテナは含みません。`npm run seed`はサンプル30記事を作成するもので、実際の投稿や設定のバックアップを復元する機能ではありません。

個人用設定の`.wp-env.override.json`、`node_modules/`、`02.検証成果物/`、環境変数ファイル・秘密鍵などはGit対象外です。認証情報や実データを追加しないでください。

## 既知の事項

- ローカル検証用の構成です。wp-env標準のポート公開は全インターフェースを対象とし、localhost限定ではありません。インターネットへ公開するサーバーの構成としては使用しません。
- 構築時のnpm auditで依存パッケージの脆弱性通知が残っています。詳細は検証記録を参照してください。
- wp-envの従来のテスト環境設定には非推奨の通知があります。更新時に設定移行の確認が必要です。

## ドキュメント

- [環境構成と採用理由](00.ドキュメント/01.環境構成.md)
- [ディレクトリ構成](00.ドキュメント/02.ディレクトリ構成案.md)
- [Windows構築手順](00.ドキュメント/06.Windows構築手順.md)
- [構築・運用手順](00.ドキュメント/03.構築・運用手順.md)
- [構築・検証記録](00.ドキュメント/04.構築・検証記録.md)
- [初期データの説明](03.初期データ/README.md)
- [作業方針](AGENT.md)（エージェント向け入口：[AGENTS.md](AGENTS.md)）
