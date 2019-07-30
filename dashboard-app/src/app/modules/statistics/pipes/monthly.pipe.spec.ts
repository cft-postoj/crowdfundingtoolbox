import { MonthlyPipe } from './monthly.pipe';

describe('MonthlyPipe', () => {
  it('create an instance', () => {
    const pipe = new MonthlyPipe();
    expect(pipe).toBeTruthy();
  });
});
