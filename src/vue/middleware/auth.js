export default function auth({ next, store }) {
  if (!SHINYU.user.logged_in) {
    return next({
      name: 'Login',
    })
  }

  return next()
}
