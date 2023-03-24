export default function guest({ next }) {
  if (SHINYU.user.logged_in) {
    return next({
      name: 'Account',
    })
  }

  return next()
}
