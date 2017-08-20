   script.onreadystatechange = function () {
                  // IE 7 fix
                  if (this.readyState === 'complete' || this.readyState === 'loaded') {
                    moduleLoadedCallback();
                    // Handle memory leak in IE
                    this.onload = null;
                    this.onreadystatechange = null;
                  }
                };
                appendToElement.appendChild(script);
              }
            }
          });
        };

      if (path) {
        loadModuleScripts(modules, path);
      } else {
        var findScriptPathAndLoadModules = function () {
          var foundPath = false;
          $('script[src*="form-validator"]').each(function () {
            foundPath = this.src.substr(0, this.src.lastIndexOf('/')) + '/';
            if (foundPath === '/