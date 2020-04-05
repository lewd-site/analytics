import config from './config';

declare global {
  interface Window {
    analytics?: Analytics;
  }
}

export interface Analytics {
  readonly event: (event: string, data?: string) => void;
}

export const analytics: Analytics = {
  event(event: string, data?: string) {
    const origin = document.location.origin
      || `${document.location.protocol}//${document.location.hostname}`;

    const path = `${document.location.pathname}${document.location.search}${document.location.hash}`;

    const formData = new FormData();
    formData.append('event', event);
    formData.append('data', data || '');
    formData.append('host', origin);
    formData.append('path', path);

    const url = `${config.url}/api/collect`;
    navigator.sendBeacon(url, formData);
  },
};

export default analytics;

window.analytics = analytics;

setTimeout(() => {
  analytics.event('pageview');
});

(() => {
  const onError = window.onerror;

  window.onerror = (msg, url, line, col, error) => {
    setTimeout(() => {
      const data: any = { msg, url, line, col, error };

      analytics.event('error', data);
    });

    if (onError) {
      return onError(msg, url, line, col, error);
    }

    return false;
  }
})();

(() => {
  const KEEP_ALIVE_INTERVAL = 1000 * 60 * 10; // Milliseconds.

  let time = 0;

  setTimeout(() => {
    time += KEEP_ALIVE_INTERVAL / 1000;
    analytics.event('keep-alive', JSON.stringify({ time }));
  }, KEEP_ALIVE_INTERVAL);
})();

(() => {
  const getNodeName = (node: HTMLElement) => {
    let name = `${node.localName}`;
    if (node.id) {
      name += `#${node.id}`;
    } else if (node.className) {
      name += `.${node.className.split(' ').join('.')}`;
    }

    return name;
  };

  document.addEventListener('click', e => {
    setTimeout(() => {
      const data: any = {
        x: e.pageX,
        y: e.pageY,
      };

      if (e.target instanceof HTMLElement) {
        data.node = getNodeName(e.target);
      }

      analytics.event('click', JSON.stringify(data));
    });
  }, { capture: true });
})();
