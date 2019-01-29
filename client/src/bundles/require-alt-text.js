import Injector from 'lib/Injector';

Injector.transform(
  'require-alt-text',
  (updater) => {
    updater.form.addValidation(
      'AssetAdmin.*',
      (values, Validation) => {
        const alt = (!values.AltText || values.AltText.length < 1) ? 'Alt text is required' : null

        if (alt) {
          Validation.addError('AltText', alt);
        }
      }
    );
  }
);
