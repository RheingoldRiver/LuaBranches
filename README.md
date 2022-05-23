# LuaBranches
This extension is based on [a fork of Scribunto](https://github.com/RheingoldRiver/scribunto-fork-idk) that adds two hooks, one in the `invoke` parser function hook and one in the function `LuaEngine::loadPackage`. It's a pretty minimal set of changes and it would be super cool if Scribunto actually patched something like that so that this extension could be used for real, because branches in Lua would be **awesome**. But for now this extension is mostly theoretical.

## Usage

When invoking a module, you may optionally set the parameter `_branch`.

* If you omit this parameter, nothing happens.
* If you set this parameter, any module that has an existing page located at the specified branch location (see "Config") will have the branched version loaded instead. Modules without branches have their normal versions loaded. (No existence checks are performed if the parameter `_branch` is unspecified.)

## Config

By default, the branch name is a subpage of your modules, for example `/Sandbox` or `/my-branch`. This can be configured by `wgLuaBranchesBranchPattern` because apparently I'm super tryhard even in a fake extension that can't actually be used by anyone.

## Limitations

Because the caching is done in the Lua engine and not PHP, I was not able to overwrite any kind of per-page caching here. So if you set a branch (or, perhaps more importantly, if you **don't** set one), you're stuck with that decision for the entire page.

In particular, you may get some very weird results if you specify a branch, and there was an earlier invoke on the page that set the cache to a different branch unexpectedly for some of your dependencies. It's recommended to use this extension (as if you could actually use it haha) with only a single invoke on a sandbox page at a time, as it's really intended only for testing.

Additionally, the extistence checks are not done all at once, so there can be a significant performance cost (though as mentioned earlier, this cost is **only** incurred if a branch was specified) (unless my code sucks). This shouldn't be too big a problem though because, again, the extension is really only intended for sandboxing, so no content pages will be affected by the performance hit.