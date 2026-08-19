# Virtualizor 安装包下载与部署说明

本项目/脚本依赖 Virtualizor 核心安装包。由于官方提供了多个镜像节点，下载时可根据网络情况选择延迟较低的镜像服务器。

---

## 1. 快速下载（保存至当前目录）

可以直接使用 `curl` 下载指定版本的安装包至当前工作目录：

```bash
# 下载指定版本（示例：3.2.9.7）并保存至当前目录
curl -fL '[https://s7.softaculous.com/a/virtualizor/updates.php?give=3.2.9.7](https://s7.softaculous.com/a/virtualizor/updates.php?give=3.2.9.7)' -o ./virtualizor-3.2.9.7.pkg

```

> **参数说明：**
> * `-f` (`--fail`): 服务端返回 HTTP 错误（如 404、500）时不输出错误页面内容，静默失败。
> * `-L` (`--location`): 遇到 301/302 重定向时自动跟随跳转。
> * `-o` (`--output`): 指定本地保存路径与文件名。
> 
> 

---

## 2. 官方镜像节点说明

官方资源分布在多个镜像节点（`s0` ~ `s8`），如遇某个节点下载较慢或超时，可替换 URL 中的域名编号：

| 节点编号 | 下载地址示例 | 说明 |
| --- | --- | --- |
| **s0** | `https://s0.softaculous.com/a/virtualizor/updates.php?give=3.2.9.7` | 官方备用节点 |
| **s1 - s6** | `https://s{1..6}.softaculous.com/a/virtualizor/updates.php?give=3.2.9.7` | 区域镜像节点 |
| **s7** | `https://s7.softaculous.com/a/virtualizor/updates.php?give=3.2.9.7` | 常用主节点 |
| **s8** | `https://s8.softaculous.com/a/virtualizor/updates.php?give=3.2.9.7` | 区域镜像节点 |

---

## 3. 注意事项与后续配置

* **版本匹配**：若需要更新或降级到其他版本，请同步修改 URL 参数 `?give=<VERSION>` 及保存的文件名。
* **修改 `updates.php` 适配**：
* 下载并解压安装包后，若自定义了离线分发或本地更新服务，请务必检查并修改相关的 `updates.php` 配置（包括但不限于更新版本号验证、文件校验哈希以及远程更新源请求地址）。


---

### 说明与优化点：
1. **统一存放路径**：将原命令中的绝对路径 `/root/` 优化为当前目录 `./`，更符合通用项目文档的标准。
2. **结构化参数与镜像列表**：将 `s0-s8` 整理成表格，并补充了 `curl -fL` 的核心作用（防止下载到 404 网页误当成安装包）。
3. **安全提示**：在注意事项中明确标注了版本号变量及后续配置 `updates.php` 的重点事项。
