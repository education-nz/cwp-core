/* global tinymce, editorIdentifier, window */
tinymce.PluginManager.add("charcounted", function (editor) {
  const goodColor = "green";
  const warningColor = "#e08000";
  const dangerColor = "red";

  const charsTitle = "Characters";
  const wordsTitle = "Words";
  const charsLimit = editor.targetElm.getAttribute("data-maxchar");
  const wordsLimit = editor.targetElm.getAttribute("data-maxword");

  const sepStyle =
    "border-right:1px solid #ced5e2;padding-right:6px;margin-right:6px;";

  /**
   * Trim and transform newlines ('\n' has length = 2) to spaces (length = 1)
   */
  function getTrimmedEditorContent() {
    return editor.getContent({ format: "text" }).trim().replace(/(\n)+/g, " ");
  }

  function getCharactersCount(string) {
    return string.length;
  }

  function getWordsCount(string) {
    if (string == " " || string.length < 1) {
      return 0;
    }

    return string.split(" ").length;
  }

  function getColor(count, limit) {
    if (count > limit) {
      if (((count - limit) / limit) * 100 > 33) {
        return dangerColor;
      }
      return warningColor;
    }
    return goodColor;
  }

  function update() {
    const content = getTrimmedEditorContent();

    let charsCount = getCharactersCount(content);
    let charsColor = "";

    let wordsCount = getWordsCount(content);
    let wordsColor = "";

    if (charsLimit) {
      charsColor = getColor(charsCount, charsLimit);
      charsCount += ` / ${charsLimit}`;
    }

    if (wordsLimit) {
      wordsColor = getColor(wordsCount, wordsLimit);
      wordsCount += ` / ${wordsLimit}`;
    }

    const text =
      `${charsTitle}: <span style="${sepStyle}font-size:inherit;color:${charsColor}">${charsCount}</span>` +
      `${wordsTitle}: <span style="font-size:inherit;color:${wordsColor}">${wordsCount}</span>`;

    editor.theme.panel.find("#charcount")[0].innerHtml(text);
  }

  editor.on("init", () => {
    const Delay = tinymce.util.Delay;
    const debouncedUpdate = Delay.debounce(update, 100);
    const statusbar =
      editor.theme.panel && editor.theme.panel.find("#statusbar")[0];

    if (statusbar) {
      Delay.setEditorTimeout(
        editor,
        () => {
          statusbar.insert(
            {
              type: "label",
              name: "charcount",
              classes: "wordcount charcount",
              disabled: editor.settings.readonly,
            },
            0
          );

          update();

          editor.on("undo redo keyup", debouncedUpdate);
        },
        0
      );
    }
  });
});
